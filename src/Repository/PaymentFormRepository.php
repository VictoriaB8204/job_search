<?php

namespace App\Repository;

use App\Entity\PaymentForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaymentForm|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentForm|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentForm[]    findAll()
 * @method PaymentForm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentFormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentForm::class);
    }

    // /**
    //  * @return PaymentForm[] Returns an array of PaymentForm objects
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
    public function findOneBySomeField($value): ?PaymentForm
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
