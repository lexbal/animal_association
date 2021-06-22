<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route(
     *     "/register",
     *     name="register"
     * )
     * @Template("security/register.html.twig")
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordEncoder
     * @return RedirectResponse|array
     */
    public function register(Request $request, UserPasswordHasherInterface $passwordEncoder)
    {
        $form = $this->createForm(
            RegistrationFormType::class,
            $user = new User()
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        $registrationForm = $form->createView();

        return compact('registrationForm');
    }
}
