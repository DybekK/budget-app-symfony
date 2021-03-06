<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    /**
     * @return Transaction[] Returns an array of Transaction objects
     */
    public function findByDate($user_id, $start_date, $end_date)
    {
        return $this->createQueryBuilder('t')
        ->select('t.id, t.transactionname, t.type, t.amount, k.id as kind_id, k.kindname, k.iconColor, t.updated_at')
        ->join('t.kind', 'k')
        ->join('t.users', 'u')
        ->where('u.id = :user_id')
        ->andwhere('t.created_at >= :start')
        ->andWhere('t.created_at <= :end')
        ->setParameter('user_id', $user_id)
        ->setParameter('start',$start_date, \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE)                      
        ->setParameter('end',$end_date, \Doctrine\DBAL\Types\Types::DATETIME_MUTABLE)
        ->getQuery()
        ->getResult(); 
    }
    

    /*
    public function findOneBySomeField($value): ?Transaction
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
