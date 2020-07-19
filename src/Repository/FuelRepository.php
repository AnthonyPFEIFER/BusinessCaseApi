<?php

namespace App\Repository;

use App\Entity\Fuel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fuel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fuel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fuel[]    findAll()
 * @method Fuel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FuelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fuel::class);
    }
    public function getAllFuels()
    {
        return $this->createQueryBuilder('f')
            ->select('f.id, f.type')
            ->getQuery()
            ->getResult();
    }

    public function getFuelById($id)
    {
        return $this->createQueryBuilder('f')
            ->select('f.id, f.type')
            ->where('f.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult();
    }
}
