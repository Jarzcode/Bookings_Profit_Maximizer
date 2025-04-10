<?php

declare(strict_types=1);

namespace SFL\Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use SFL\Shared\Domain\Aggregate\AggregateRoot;

abstract class DoctrineRepository
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    protected function entityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function persist(AggregateRoot $entity): void
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush();
    }

    protected function remove(AggregateRoot $entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush();
    }

    /**
     * @template T of object
     *
     * @psalm-param class-string<T> $entityClass
     *
     * @psalm-return EntityRepository<T>
     */
    protected function repository(string $entityClass): EntityRepository
    {
        return $this->entityManager->getRepository($entityClass);
    }
}
