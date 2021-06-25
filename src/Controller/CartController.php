<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * Class CartController
 * @package App\Controller
 * @Route("/cart")
 * @IsGranted("IS_AUTHENTICATED_FULLY")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="cart")
     * @Template("cart/index.html.twig")
     * @return array
     */
    public function cart(): array
    {
        /** @var User $user */
        if (!$user = $this->getUser()) {
            throw new AccessDeniedException("Access Denied !");
        }

        $accessories = $user->getAnimalAccessories();
        $animals     = $user->getAnimals();

        return compact('accessories', 'animals');
    }
}
