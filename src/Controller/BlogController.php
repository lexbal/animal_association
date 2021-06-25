<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class BlogController
 * @package App\Controller
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog")
     * @Template("blog/index.html.twig")
     * @return array
     */
    public function index(): array
    {
        $em    = $this->getDoctrine()->getManager();
        /** @var PostRepository $repo */
        $repo  = $em->getRepository(Post::class);
        $posts = $repo->findBy(['parent' => null]);

        return compact('posts');
    }
}
