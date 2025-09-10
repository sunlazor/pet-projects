<?php

namespace App\Services;

use App\Entity\User;
use Doctrine\DBAL\Connection;
use Sunlazor\BlondFramework\Authentication\AuthUserInterface;
use Sunlazor\BlondFramework\Authentication\UserServiceInterface;

class UserService implements UserServiceInterface
{
    public function __construct(private Connection $connection) {}

    public function save(User $user): int
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->insert('users')
            ->values(['name' => ':name', 'email' => ':email', 'password' => ':password', 'created_at' => ':created_at'])
            ->setParameters(
                [
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
                    'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s'),
                ],
            )
            ->executeQuery();

        return $this->connection->lastInsertId();
    }

    public function findById(int $id): User|null
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('*')->from('users')->where('id = :id')->setParameter('id', $id);
        $result = $qb->executeQuery()->fetchAssociative();

        if (empty($result)) {
            return null;
        }

        return new User(
            $result['id'],
            $result['email'],
            $result['password'],
            $result['name'],
            new \DateTimeImmutable($result['created_at']),
        );
    }

    public function findByEmail(string $email): AuthUserInterface|null
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->select('*')
            ->from('users')
            ->where('email = :email')
            ->setParameter('email', $email);
        $result = $qb->executeQuery()->fetchAssociative();

        if (empty($result)) {
            return null;
        }

        return new User(
            $result['id'],
            $result['email'],
            $result['password'],
            $result['name'],
            new \DateTimeImmutable($result['created_at']),
        );
    }
}