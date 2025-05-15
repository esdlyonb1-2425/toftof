<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Share;
use App\Repository\ProfileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ShareController extends AbstractController
{
    #[Route('/sharewith/{id}', name: 'app_share_with')]
    public function shareWith(Post $post): Response
    {
        return $this->render('share/index.html.twig', [
            'controller_name' => 'ShareController',
            'post' => $post,
        ]);
    }

    #[Route('/share/{post}/{recipient}', name: 'app_share')]
    public function share(Post $post, $recipientId, ProfileRepository $profileRepository, EntityManagerInterface $manager): Response
    {

        $recipient = $profileRepository->find($recipientId);

        $share = new Share();
        $share->setPost($post);
        $share->setSender($this->getUser()->getProfile());
        $share->setRecipient($recipient);
        $manager->persist($share);
        $manager->flush();
        return $this->redirectToRoute('app_home');

    }
}
