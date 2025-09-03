<?php

namespace App\Services;

use App\Entity\Post;
use Doctrine\DBAL\Connection;

class PostService
{
    public function __construct(private Connection $connection) {}

    public function save(Post $post): int
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->insert('posts')
            ->values(['title' => ':title', 'body' => ':body', 'created_at' => ':created_at'])
            ->setParameters(
                [
                    'title' => $post->getTitle(),
                    'body' => $post->getContent(),
                    'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s'),
                ],
            )
            ->executeQuery();

        return $this->connection->lastInsertId();
    }

    public function findById(int $id): Post|null
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('*')->from('posts')->where('id = :id')->setParameter('id', $id);
        $result = $qb->executeQuery()->fetchAssociative();

        if (empty($result)) {
            return null;
        }

        return new Post(
            $result['id'], $result['title'], $result['body'], new \DateTimeImmutable($result['created_at']),
        );
    }
}