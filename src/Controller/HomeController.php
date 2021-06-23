<?php


namespace App\Controller;


use App\Entity\Animal;
use App\Entity\AnimalAccessory;
use App\Entity\Donation;
use App\Entity\User;
use App\Form\DonationType;
use App\Repository\AnimalAccessoryRepository;
use App\Repository\AnimalRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    /**
     * @Route(
     *     "/",
     *     name="home"
     * )
     * @Template("index.html.twig")
     * @return array
     */
    public function home(Request $request)
    {
        $em                  = $this->getDoctrine()->getManager();
        /** @var AnimalRepository $repo */
        $animalRepo          = $em->getRepository(Animal::class);
        /** @var AnimalAccessoryRepository $repo */
        $animalAccessoryRepo = $em->getRepository(AnimalAccessory::class);
        //$repo->findBy(["adopted" => false, "adopted_at" => null], [], 8);
        $animals             = $animalRepo->findByEightAnimalNotAdopted();
        $animalAccessories   = $animalAccessoryRepo->findByAvailableAccessory();
        $form = $this->createForm(DonationType::class, $donation = new Donation());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$this->isCsrfTokenValid('donation_token', $request->request->get("donation")["_token"])) {
                throw new InvalidCsrfTokenException();
            }

            /** @var User $user */
            if ($user = $this->getUser()) {
                $donation->setDonator($user);
            }

            $em->persist($donation);
            $em->flush();
        }

        $form = $form->createView();

        return compact('animals', 'animalAccessories', 'form');
    }
}