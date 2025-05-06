<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PostController extends AbstractController
{
    #[Route('/feed', name: 'app_feed')]
    public function index(PostRepository $repo): Response
    {


        $posts = $repo->findAll();


        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
