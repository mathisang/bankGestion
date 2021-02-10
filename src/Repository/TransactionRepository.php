<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    // /**
    //  * @return Transaction[] Returns an array of Transaction objects
    //  */


    // RECUPERER AVEC VIRGULE POUR AFFICHAGE ET SANS POUR CALCUL
    // OU FUNCTION QUI PLACE UNE VIRGULE A LA BONNE PLACE

    public function findCommun()
    {
        return $this->createQueryBuilder('t')
            ->select("t.id, REPLACE(t.amount, ',', '') as amount, t.description, t.dateTransaction, t.type, t.categorie, t.username, t.statut")
            ->andWhere('t.type != 3')
            ->orderBy('t.statut', 'ASC')
            ->addOrderBy('t.dateTransaction', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPerso($user)
    {
        return $this->createQueryBuilder('t')
            ->select("t.id, REPLACE(t.amount, ',', '') as amount, t.description, t.dateTransaction, t.type, t.categorie, t.username, t.statut")
            ->andWhere('t.username = :user')
            ->setParameter('user', $user)
            ->orderBy('t.dateTransaction', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findDepensesMonth($user, $start, $end)
    {
        return $this->createQueryBuilder('t')
            ->select("SUM(REPLACE(t.amount, ',', '')) as amount")
            ->andWhere('t.username = :user')
            ->andWhere('t.dateTransaction >= :debut')
            ->andWhere('t.dateTransaction <= :fin')
            ->setParameter('user', $user)
            ->setParameter('debut', $start)
            ->setParameter('fin', $end)
            ->orderBy('t.dateTransaction', 'DESC')
            ->getQuery()
            ->getResult()
        ;
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
