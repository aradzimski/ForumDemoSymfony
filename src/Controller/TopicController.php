<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TopicRepository;

class TopicController extends AbstractController
{
    private TopicRepository $topicRepository;

    public function __construct(TopicRepository $topicRepository)
    {
        $this->topicRepository = $topicRepository;
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
}
