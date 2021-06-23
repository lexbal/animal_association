<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class AnimalAccessoryController
 * @package App\Controller
 * @Route("/animal_accessory")
 */
class AnimalAccessoryController extends AbstractController
{
    /**
     * @Route("/", name="animal_accessory")
     * @Template("animal_accessory/index.html.twig")
     * @return array
     */
    public function index(): array
    {
        // Récuperation de tout les accessoires depuis la BDD

        // Doit retourné l'array precedant
        return [];
    }

    /**
     * @Route("/{id}", name="animal_accessory_detail")
     * @Template("animal_accessory/detail.html.twig")
     * @param int $id
     * @return array
     */
    public function detail(int $id): array
    {
        // Récuperation de l'accessoire depuis la BDD grâce à l'id en paramètre de fonction

        // Doit retourné l'entity AnimalAccessory de l'id en paramètre
        return [];
    }

    /**
     * @Route("/", name="animal_accessory_add_to_cart")
     * @return array
     */
    public function addToCart(): array
    {
        // Sera executé via du AJAX

        // Il faudra :
        // - Ajouter l'accessoire a l'utilisateur
        // - Bloquer le bouton au non connecté
        // - Baisser la quantité d'accessoire
        // etc...

        // Certainement return un $this->json(['success' => true, 'message' => '']);
        // ou $this->json(['success' => false, 'message' => '']); en cas d'erreur
        // si nous utilisons AJAX
        return [];
    }
}
