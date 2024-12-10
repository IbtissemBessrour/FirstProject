<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

public function tri(){
$entityManager=$this->getEntityManager();
$query=$entityManager
->createQuery('SELECT b FROM App\Entity\Book b ORDER BY b.title ASC');
return $query->getResult();
}


public function triQB(){
    $queryBuilder=$this
    ->createQueryBuilder('b')
    ->orderBy('b.title', 'ASC')
    ->getQuery()
    ->getResult();
}


public function searchBookByRef($id){

    $queryBuilder=$this
    ->createQueryBuilder('v')
    ->where('v.id = :id')
    ->setParameter('id', $id)
    ->getQuery()
    ->getResult();
    return $queryBuilder;
}



//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
