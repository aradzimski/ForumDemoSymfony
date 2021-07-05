<?php

namespace App\Controller;

use App\Form\ReplyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Repository\TopicRepository;
use App\Repository\PostRepository;

class TopicController extends AbstractController
{
    private TopicRepository $topicRepository;
    private PostRepository $postRepository;

    public function __construct(TopicRepository $topicRepository, PostRepository $postRepository)
    {
        $this->topicRepository = $topicRepository;
        $this->postRepository = $postRepository;
    }

    /**
     * @Route("/topic/{id}/{urltitle}", name="app_topic")
     */
    public function index(int $id): Response
    {
        $topic = $this->topicRepository->find($id);

        return $this->render('topic/index.html.twig', [
            'controller_name' => 'TopicController',
            'topic' => $topic,
        ]);
    }

    /**
     * @Route("/topic/{id}/{urltitle}/reply", name="app_reply")
     */
    public function reply(Request $request): Response
    {
        $post = new Post();
        $topic = $this->topicRepository->find($request->get('id'));

        $post->setUser(
            $this->get('security.token_storage')->getToken()->getUser()
        );
        $post->setTopic($topic);

        $form = $this->createForm(ReplyType::class, $post);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $post = $form->getData();

            $this->postRepository->add($post);

            return $this->redirectToRoute('app_topic',
                array(
                    'id' => $topic->getId(),
                    'urltitle' => $topic->getUrlTitle()
                )
            );
        }

        return $this->render('post/reply.html.twig', [
            'form' => $form->createView(),
            'topic' => $topic,
        ]);
    }
}
