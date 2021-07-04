<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ForumRepository;

class ForumController extends AbstractController
{
    private ForumRepository $forumRepository;

    public function __construct(ForumRepository $forumRepository)
    {
        $this->forumRepository = $forumRepository;
    }

    /**
     * @Route("/forum/{id}/{urltitle}", name="app_forum")
     */
    public function index(int $id): Response
    {
        $forum = $this->forumRepository->find($id);

        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
            'forum' => $forum,
        ]);
    }
}
