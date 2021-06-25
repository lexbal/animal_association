<?php

namespace App\Controller;

use App\Entity\AnimalAccessory;
use App\Entity\User;
use App\Repository\AnimalAccessoryRepository;
use Nzo\UrlEncryptorBundle\Annotations\ParamDecryptor;
use Nzo\UrlEncryptorBundle\Encryptor\Encryptor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * Class AnimalAccessoryController
 * @package App\Controller
 * @Route("/animal_accessory")
 */
class AnimalAccessoryController extends AbstractController
{
    /**
     * @var Encryptor
     */
    private $encryptor;


    /**
     * AnimalAccessoryController constructor.
     * @param Encryptor $encryptor
     */
    public function __construct(Encryptor $encryptor)
    {
        $this->encryptor = $encryptor;
    }

    /**
     * @Route("/", name="animal_accessory")
     * @Template("animal_accessory/index.html.twig")
     * @return array
     */
    public function index(): array
    {
        $em          = $this->getDoctrine()->getManager();
        /** @var AnimalAccessoryRepository $repo */
        $repo        = $em->getRepository(AnimalAccessory::class);
        $accessories = $repo->findAll();

        return compact('accessories');
    }

    /**
     * @Route("/detail/{id}", name="animal_accessory_detail")
     * @Template("animal_accessory/detail.html.twig")
     * @ParamDecryptor(params={"id"})
     * @param int $id
     * @return array
     */
    public function detail(int $id): array
    {
        $em        = $this->getDoctrine()->getManager();
        /** @var AnimalAccessoryRepository $repo */
        $repo      = $em->getRepository(AnimalAccessory::class);

        if (!$accessory = $repo->find($id)) {
            throw new NotFoundHttpException("Accessory not found !");
        }

        return compact('accessory');
    }

    /**
     * @Route("/add_to_cart", name="animal_accessory_add_to_cart", methods={"POST"})
     * @param Request $request
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @return JsonResponse
     */
    public function addToCart(Request $request): JsonResponse
    {
        $em   = $this->getDoctrine()->getManager();
        /** @var AnimalAccessoryRepository $repo */
        $repo = $em->getRepository(AnimalAccessory::class);

        /** @var AnimalAccessory $accessory */
        if (!$accessory = $repo->find($this->encryptor->decrypt(
            $request->request->get('id')
        ))) {
            throw new NotFoundHttpException("Cannot find accessory !");
        }

        /** @var User $user */
        if (!$user = $this->getUser()) {
            throw new AccessDeniedException("Access Denied !");
        }

        if (($quantity = $accessory->getQuantity()) > 0 && !$user->getAnimalAccessories()->contains($accessory)) {
            $accessory->setQuantity(
                $quantity - 1
            );

            $user->addAnimalAccessory($accessory);

            $em->persist($user);
            $em->persist($accessory);
        }

        $em->flush();

        return $this->json([
            'success'  => true,
            'cart'     => $user->getCart(),
            'quantity' => $accessory->getQuantity(),
        ]);
    }
}
