<?php

namespace App\Repository;

use App\Entity\Model;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Model|null find($id, $lockMode = null, $lockVersion = null)
 * @method Model|null findOneBy(array $criteria, array $orderBy = null)
 * @method Model[]    findAll()
 * @method Model[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Model::class);
    }
    public function getModeles()
    {
        return $this->createQueryBuilder('m')
            ->select('m.id, m.name')
            ->getQuery()
            ->getResult();
    }
    public function getModeleById($id)
    {
        return $this->createQueryBuilder('m')
            ->select('m.id, m.name')
            ->where('m.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult();
    }
    public function getModeleByBrand($id)
    {
        return $this->createQueryBuilder('m')
            ->select('m.id, m.name')
            ->innerJoin('m.brand', 'b')
            ->where('b.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult();
    }
}
