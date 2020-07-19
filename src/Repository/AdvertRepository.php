<?php

namespace App\Repository;

use App\Entity\Advert;
use App\Entity\Professional;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Advert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advert[]    findAll()
 * @method Advert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Advert::class);
    }

    public function getAllAdverts()
    {
        return $this->createQueryBuilder('a')
            ->select('a.id, a.title, a.description, a.dateImmat,  a.km,  a.price, a.ref, f.type, m.name, b.name ')
            ->join('a.fuel', 'f')
            ->join('a.model', 'm')
            ->join('m.brand', 'b')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(15)
            ->getQuery()
            ->getResult();
    }

    public function getAdvertById($id)
    {
        return $this->createQueryBuilder('a')
            ->select('a.id, a.title, a.description, a.dateImmat,  a.km,  a.price, a.ref, f.type, b.name AS brandName , mo.name')
            ->join('a.fuel', 'f')
            ->join('a.model', 'mo')
            ->join('mo.brand', 'b')
            ->where('a.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult();
    }

    public function getAdvertByGarage($id)
    {
        return $this->createQueryBuilder('a')
            ->select('a.id, a.title, a.description, a.dateImmat,  a.km,  a.price, a.ref, f.type, b.name AS brandName , mo.name')
            ->join('a.fuel', 'f')
            ->join('a.model', 'mo')
            ->join('mo.brand', 'b')
            ->join('a.garage', 'g')
            ->where('g.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult();
    }

    public function getAdvertByPro($id)
    {
        return $this->createQueryBuilder('a')
            ->select('a.id, a.title, a.description, a.dateImmat,  a.km,  a.price, a.ref, f.type, b.name AS brandName , mo.name')
            ->join('a.fuel', 'f')
            ->join('a.model', 'mo')
            ->join('mo.brand', 'b')
            ->join('a.garage', 'g')
            ->join('g.professional', 'p')
            ->where('p.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult();
    }
    public function getAdvertsBySearch($fuel, $dateImmat, $km, $price, $model, $brand)
    {
        $querybuilder = $this->createQueryBuilder('a');
        if ($dateImmat !== null) {
            $querybuilder->where('a.dateImmat > :dateImmat')
                ->setParameter('dateImmat', $dateImmat);
        } elseif ($km !== null) {
            $querybuilder->andWhere('a.km < :km')
                ->setParameter('km', $km);
        } elseif ($price !== null) {
            $querybuilder->andWhere('a.price < :price')
                ->setParameter('price', $price);
        } elseif ($brand !== null) {
            $querybuilder->andWhere('b.name LIKE :brand')
                ->join('a.model', 'm')
                ->join('m.brand', 'b')
                ->setParameter('brand', $brand);
        } elseif ($model !== null) {
            $querybuilder->andWhere('m.name LIKE :model')
                ->join('a.model', 'm')
                ->join('m.brand', 'b')
                ->setParameter('model', $model);
        } elseif ($fuel !== null) {
            $querybuilder->andWhere('f.type LIKE :fuel')
                ->join('a.fuel', 'f')
                ->setParameter('fuel', $fuel);
        }
        return $querybuilder->getQuery()->getResult();
    }

    public function getNumberOfAdverts()
    {
        return $this->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getResult();
    }
}
