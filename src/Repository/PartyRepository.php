<?php

namespace App\Repository;

use App\Entity\Party;
use App\Entity\Travel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Party|null find($id, $lockMode = null, $lockVersion = null)
 * @method Party|null findOneBy(array $criteria, array $orderBy = null)
 * @method Party[]    findAll()
 * @method Party[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Party::class);
    }


public function findByTravel(Travel $travel, int $limit)
{

    $qb= $this->createQueryBuilder('p');
    $qb->innerJoin('p.travels', 't')
        ->select('p', 't')
        ->where($qb->expr()->eq('t.id', ':travel'))

        ->orderBy('p.createdAt', 'DESC');


    if ($limit) {
        $qb->setMaxResults($limit);
    }
    return $qb->setParameter(':travel', $travel->getParty())
        ->getQuery()
        ->getResult();

}

    public function searchBy(string $sq)
    {
        $sq = "%$sq%";
        $qb = $this->createQueryBuilder('p');
        $qb = $qb
            ->where($qb->expr()->orX(
                $qb->expr()->like('p.name', ':sq'))

           );
        return $qb->setParameter(':sq', $sq)->getQuery()->getResult();
    }



    // /**
    //  * @return Party[] Returns an array of Party objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Party
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
