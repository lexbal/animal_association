<?php

namespace App\Controller\Security;

use LogicException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/**
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * @Route(
     *     "/login",
     *     name="login"
     * )
     * @Template("security/login.html.twig")
     * @param AuthenticationUtils $authenticationUtils
     * @return array
     */
    public function login(AuthenticationUtils $authenticationUtils): array
    {
        $error        = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return compact('lastUsername', 'error');
    }

    /**
     * @Route(
     *     "/logout",
     *     name="logout"
     * )
     */
    public function logout()
    {
        throw new LogicException(
            'This method can be blank - it will be intercepted by the logout key on your firewall.'
        );
    }
}
