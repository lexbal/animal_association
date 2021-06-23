<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
        // Récuperation de tout les animaux depuis la BDD
        // Récuperation des tout les animaux adoptées les mois dernier depuis la BDD

        // Doit retourné les 2 array precedant
        return [];
    }

    /**
     * @Route("/{id}", name="animal_detail")
     * @Template("animal/detail.html.twig")
     * @param int $id
     * @return array
     */
    public function detail(int $id): array
    {
        // Récuperation de l'animal depuis la BDD grace a l'id en parametre de fonction

        // Doit retourné l'entity Animal de l'id en parametre
        return [];
    }
}
