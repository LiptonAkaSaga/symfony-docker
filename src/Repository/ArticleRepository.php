<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findAllOrderedByNewest()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.dateAdded', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findLatest(int $limit = 5)
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.dateAdded', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function countArticles()
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getLastArticle()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function searchByTitle(string $query)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('LOWER(a.title) LIKE LOWER(:query)')
            ->setParameter('query', '%'.strtolower($query).'%')
            ->orderBy('a.dateAdded', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
