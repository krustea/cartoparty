<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Party;
use App\Entity\Travel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Travel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Travel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Travel[]    findAll()
 * @method Travel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TravelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Travel::class);
    }

//    public function findLast(int $limit) : array
//    {
//        $qb= $this->createQueryBuilder('t');
//
//        $qb->select('t')
//            ->innerJoin('t.party','p')
//            ->innerJoin('t.category','c')
//            ->orderBy('t.createdAt','DESC')
//            ->setMaxResults($limit);
//        return $qb->getQuery()->getResult();
//
//    }

    public function findByCategory(?Party $party, Category $category, int $limit) : array
    {
        $qb = $this->createQueryBuilder('t');

        $qb->select('t', 'c', 'p')
            ->innerJoin('t.category','c')
            ->innerJoin('t.party','p')
            ->where($qb->expr()->eq('c.id', ':category_id'))
        ;

        if ($party !== null) {
            $qb->andWhere($qb->expr()->eq('p.id', ':party_id'));
        }

        $qb->orderBy('t.createdAt', 'DESC');

        $qb->setParameter(':category_id', $category->getId());

        if ($party !== null) {
            $qb->setParameter(':party_id', $party->getId());
        }

        return $qb->getQuery()->getResult();


    }

//    public function findByTravel(Travel $travel, int $limit) : array
//    {
//        $qb = $this->createQueryBuilder('t');
//
//        $qb->select('t')
//            ->innerJoin('t.party', 'p')
//
//
//
//    }











    // /**
    //  * @return Travel[] Returns an array of Travel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Travel
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
