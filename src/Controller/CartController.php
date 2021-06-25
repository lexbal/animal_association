<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\AnimalAccessory;
use App\Entity\User;
use Nzo\UrlEncryptorBundle\Annotations\ParamDecryptor;
use Nzo\UrlEncryptorBundle\Encryptor\Encryptor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/remove", name="remove_item")
     * @Template("cart/index.html.twig")
     * @param Request $request
     * @return RedirectResponse
     */
    public function remove(Request $request): RedirectResponse
    {
        /** @var User $user */
        if (!$user = $this->getUser()) {
            throw new AccessDeniedException("Access Denied !");
        }

        $em = $this->getDoctrine()->getManager();
        $id = $this->encryptor->decrypt(
            $request->query->get('id')
        );

        switch ($request->query->get('type')) {
            case "animal":
                /** @var Animal $animal */
                if ($animal = $em->getRepository(Animal::class)->find($id)) {
                    $animal->setAdopted(false);
                    $animal->setAdoptedAt(null);
                    $em->persist($animal);

                    $user->removeAnimal($animal);
                }
                break;
            case "accessory":
                /** @var AnimalAccessory $accessory */
                if ($accessory = $em->getRepository(AnimalAccessory::class)->find($id)) {
                    $user->removeAnimalAccessory($accessory);
                    $accessory->setQuantity($accessory->getQuantity() + 1);

                    $em->persist($accessory);
                }
                break;
        }

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('cart');
    }
}
