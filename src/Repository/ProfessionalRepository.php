<?php

namespace App\Repository;

use App\Entity\Professional;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Professional|null find($id, $lockMode = null, $lockVersion = null)
 * @method Professional|null findOneBy(array $criteria, array $orderBy = null)
 * @method Professional[]    findAll()
 * @method Professional[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfessionalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Professional::class);
    }
    public function apiKeyPro($username, $password)
    {
        return $this->createQueryBuilder('p')
            ->where('p.username = :username')
            ->andWhere('p.password = :password')
            ->setParameter(':username', $username)
            ->setParameter(':password', $password)
            ->getQuery()
            ->getResult();
    }
    public function getPros()
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.apiKey, p.firstname, p.username, p.email, p.siret, p.tel, p.lastname')
            ->getQuery()
            ->getResult();
    }
    public function proById($id)
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.apiKey, p.firstname, p.username, p.email, p.siret, p.tel, p.lastname')
            ->where('p.id = :id')
            ->setParameter(':id', $id)
            ->getQuery()
            ->getResult();
    }
    public function getProNumber()
    {
        return $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery()
            ->getResult();
    }
}
