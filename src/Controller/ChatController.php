<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\Profile;
use App\Form\MessageForm;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ChatController extends AbstractController
{
    #[Route('/chat/initiate/{id}', name: 'app_chat_initiate')]
    public function initiate(Profile $profile, EntityManagerInterface $manager): Response
    {
        //verifier si une conversation entre ces deux personnes existe déja
        if(!$profile){return $this->redirectToRoute('app_people');}

        $conversation = $this->getUser()->getProfile()->isChattingWith($profile);

        if(!$conversation){
            $conversation = new Conversation();
            $conversation->addParticipant($this->getUser()->getProfile());
            $conversation->addParticipant($profile);
            $conversation->setCreatedAt(new \DateTime());

            $manager->persist($conversation);
            $manager->flush();
        }


        return $this->redirectToRoute('app_chat', ['id' => $conversation->getId() ]);
    }

    #[Route('/chat/{id}', name: 'app_chat')]
    public function chat(Conversation $chat, Request $request, EntityManagerInterface $manager): Response
    {
        if(!$chat){return $this->redirectToRoute('app_people');}

        $message = new Message();
        $form = $this->createForm(MessageForm::class, $message);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $message->setAuthor($this->getUser()->getProfile());
            $message->setConversation($chat);
            $message->setCreatedAt(new \DateTime());
            $manager->persist($message);
            $manager->flush();
            return $this->redirectToRoute('app_chat', ['id' => $chat->getId()]);
        }



        return $this->render('chat/index.html.twig', [
            'chat' => $chat,
            'form' => $form,
        ]);
    }


}
