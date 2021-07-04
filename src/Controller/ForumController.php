<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ForumRepository;

class ForumController extends AbstractController
{
    private ForumRepository $forumRepository;

    public function __construct(TopicRepository $forumRepository)
    {
        $this->forumRepository = $forumRepository;
    }

    /**
     * @Route("/forum/{id}/{urltitle}", name="app_forum")
     */
    public function index(int $id): Response
    {
        $topics = $this->forumRepository->getByIdWithTopics($id);

        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
            'topics' => $topics,
        ]);
    }
}
