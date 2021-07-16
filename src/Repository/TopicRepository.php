<?php

namespace App\Repository;

use App\Entity\Topic;
use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @method Topic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topic[]    findAll()
 * @method Topic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topic::class);
    }

    public function add(Topic $topic)
    {
        $date = new \DateTime();

        $topic->setCreated($date);
        $topic->setUpdated($date);
        $topic->getPosts()[0]->setCreated($date);
        $topic->getPosts()[0]->setUpdated($date);
        $topic->getPosts()[0]->setIsEdited(0);

        $this->_em->persist($topic);
        $this->_em->flush();

        $topic_id = $topic->getId();

        return $topic_id;
    }
}
