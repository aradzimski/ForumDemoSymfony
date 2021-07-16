<?php

namespace App\Controller;

use App\Form\CreateTopicType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Forum;
use App\Entity\Topic;
use App\Entity\Post;
use App\Repository\ForumRepository;
use App\Repository\TopicRepository;

class ForumController extends AbstractController
{
private ForumRepository $forumRepository;
private TopicRepository $topicRepository;

    public function __construct(ForumRepository $forumRepository, TopicRepository $topicRepository)
    {
        $this->forumRepository = $forumRepository;
        $this->topicRepository = $topicRepository;
    }

    /**
     * @Route("/forum/{id}/{urltitle}", name="app_forum")
     */
    public function index(int $id): Response
    {
        $forum = $this->forumRepository->find($id);

        if (!$forum instanceof Forum) {
            throw new NotFoundHttpException();
        }

        return $this->render('forum/index.html.twig', [
            'controller_name' => 'ForumController',
            'forum' => $forum,
        ]);
    }

    /**
     * @Route("/forum/{id}/{urltitle}/createtopic", name="app_forum_createtopic")
     */
    public function createtopic(Request $request): Response
    {
        $forum = $this->forumRepository->find($request->get('id'));

        if (!$forum instanceof Forum) {
            throw new NotFoundHttpException();
        }

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $post = new Post();
        $post->setUser($user);

        $topic = new Topic();

        $topic->setForum($forum);
        $topic->setUser($user);
        $topic->addPost($post);

        $form = $this->createForm(CreateTopicType::class, $topic);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $topic = $form->getData();
            $topic->setUrlTitle(str_replace(" ", "-", strtolower($topic->getTitle())));

            $topic_id = $this->topicRepository->add($topic);

            return $this->redirectToRoute('app_topic',
                array(
                    'id' => $topic_id,
                    'urltitle' => $topic->getUrlTitle()
                )
            );
        }

        return $this->render('topic/create.html.twig', [
            'form' => $form->createView(),
            'forum' => $forum,
        ]);
    }
}
