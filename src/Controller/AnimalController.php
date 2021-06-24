<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AnimalRepository;
use App\Entity\Animal;
use App\Entity\User;
use Nzo\UrlEncryptorBundle\Annotations\ParamDecryptor;
use Nzo\UrlEncryptorBundle\Encryptor\Encryptor;


/**
 * Class AnimalController
 * @package App\Controller
 * @Route("/animal")
 */
class AnimalController extends AbstractController
{
    /**
     * @Route("/", name="animal")
     * @Template("animal/index.html.twig")
     * @return array
     */
    public function index(): array
    {
        $em          = $this->getDoctrine()->getManager();
        /** @var AnimalRepository $repo */
        $repo        = $em->getRepository(Animal::class);
        $animaux = $repo->findBy(["adopted" => 0, "adopted_at" => null]);

        return compact('animaux');
        // return [];
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
        $em        = $this->getDoctrine()->getManager();
        /** @var AnimalRepository $repo */
        $repo      = $em->getRepository(Animal::class);

        if (!$animal = $repo->find($id)) {
            throw new NotFoundHttpException("animal not found !");
        }

        return compact('animal');
    }



}
