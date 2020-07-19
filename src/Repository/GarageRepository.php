<?php

namespace App\Repository;

use App\Entity\Garage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Garage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Garage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Garage[]    findAll()
 * @method Garage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GarageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Garage::class);
    }

    public function getGarageById($id)
    {
        return $this->createQueryBuilder('g')
            ->select('g.name, g.tel, g.address, g.city, g.postCode, g.country')
            ->where('g.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult();
    }
    public function getAllGarages()
    {
        return $this->createQueryBuilder('g')
            ->select('g.id, g.name, g.tel, g.address,  g.city')
            ->getQuery()
            ->getResult();
    }
    public function getGarageByPro($id)
    {
        return $this->createQueryBuilder('g')
            ->select('g.id, g.name, g.tel, g.address,  g.city')
            ->join('g.professional', 'p')
            ->where('p.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult();
    }
    public function getGarageNumber()
    {
        return $this->createQueryBuilder('g')
            ->select('count(g.id)')
            ->getQuery()
            ->getResult();
    }
}
