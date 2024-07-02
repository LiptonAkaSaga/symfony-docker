<?php

namespace App\Repository;

use App\Entity\AboutMeInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AboutMeInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AboutMeInfo::class);
    }

    public function findAllSorted()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.infoKey', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByInfoKey(string $infoKey)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.infoKey = :infoKey')
            ->setParameter('infoKey', $infoKey)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function countEntries()
    {
        return $this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function deleteMultiple(array $ids): int
    {
        return $this->createQueryBuilder('a')
            ->delete()
            ->where('a.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->execute();
    }
}
