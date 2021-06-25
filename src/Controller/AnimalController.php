<?php

namespace App\Controller;

use App\Entity\User;
use DateTime;
use Exception;
use Nzo\UrlEncryptorBundle\Encryptor\Encryptor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnimalRepository;
use App\Entity\Animal;
use Nzo\UrlEncryptorBundle\Annotations\ParamDecryptor;


/**
 * Class AnimalController
 * @package App\Controller
 * @Route("/animal")
 */
class AnimalController extends AbstractController
{
    /**
     * @var Encryptor
     */
    private $encryptor;


    /**
     * AnimalController constructor.
     * @param Encryptor $encryptor
     */
    public function __construct(Encryptor $encryptor)
    {
        $this->encryptor = $encryptor;
    }

    /**
     * @Route("/", name="animal")
     * @Template("animal/index.html.twig")
     * @return array
     * @throws Exception
     */
    public function index(): array
    {
        $em             = $this->getDoctrine()->getManager();
        /** @var AnimalRepository $repo */
        $repo           = $em->getRepository(Animal::class);
        $animals        = $repo->findBy(["adopted" => 0, "adopted_at" => null]);
        $animalsAdopted = $repo->findByAdoptedPreviousMonth();

        return compact('animals', 'animalsAdopted');
    }

    /**
     * @Route("/detail/{id}", name="animal_detail")
     * @Template("animal/detail.html.twig")
     * @ParamDecryptor(params={"id"})
     * @param int $id
     * @return array
     */
    public function detail(int $id): array
    {
        $em   = $this->getDoctrine()->getManager();
        /** @var AnimalRepository $repo */
        $repo = $em->getRepository(Animal::class);

        if (!$animal = $repo->find($id)) {
            throw new NotFoundHttpException("Animal not found !");
        }

        return compact('animal');
    }

    /**
     * @Route("/add_to_cart", name="animal_add_to_cart", methods={"POST"})
     * @param Request $request
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @return JsonResponse
     * @throws Exception
     */
    public function addToCart(Request $request): JsonResponse
    {
        $em   = $this->getDoctrine()->getManager();
        /** @var AnimalRepository $repo */
        $repo = $em->getRepository(Animal::class);

        /** @var Animal $animal */
        if (!$animal = $repo->find($this->encryptor->decrypt(
            $request->request->get('id')
        ))) {
            throw new NotFoundHttpException("Cannot find animal !");
        }

        /** @var User $user */
        if (!$user = $this->getUser()) {
            throw new AccessDeniedException("Access Denied !");
        }

        if (!$animal->getAdopted()) {
            $animal->setAdopted(true);
            $animal->setAdoptedAt(new DateTime());

            $user->addAnimal($animal);

            $em->persist($user);
            $em->persist($animal);
        }

        $em->flush();

        return $this->json([
            'success'  => true,
            'cart'     => $user->getCart(),
        ]);
    }
}
