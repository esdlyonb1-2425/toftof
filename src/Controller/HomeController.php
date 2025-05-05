<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/img', name: 'app_img')]
    public function img(EntityManagerInterface $manager, Request $request): Response
    {
        if(!$this->getUser()){return $this->redirectToRoute('app_login');}
        $image = new Image();
        $form = $this->createForm(ImageForm::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image->setOf($this->getUser());
            $manager->persist($image);
            $manager->flush();
            return $this->redirectToRoute('app_img');
        }



        $image2 = new Image();
        $form2 = $this->createForm(ImageForm::class, $image2);
        $form2->handleRequest($request);
        if ($form2->isSubmitted() && $form2->isValid()) {
            $image2->setOf($this->getUser());
            $manager->persist($image2);
            $manager->flush();
            return $this->redirectToRoute('app_img');
        }


        return $this->render('home/img.html.twig', [
            'form' => $form,
            'form2' => $form2,
        ]);
    }
}
