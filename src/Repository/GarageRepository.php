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
    // /**
    //  * @return Garage[] Returns an array of Garage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Garage
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
