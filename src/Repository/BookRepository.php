<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
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
//public function listBookByClass($id)
//{
  //  return $this->createQueryBuilder('B')
    //->join('B.book','B')
    //->addSelect('B')
   // ->where('B.Id=:Id')
    //->setParameter('Id', $id)
    //->getQuery()
  //  ->getResult();
//}

public function findAllBooksOrderedByAuthor()
{
    return $this->createQueryBuilder('b')
        ->addSelect('a') 
        ->join('b.Author', 'a')
        ->orderBy('a.username', 'ASC')
        ->getQuery()
        ->getResult();
}

public function countScienceFictionBooks()
{
    return $this->createQueryBuilder('b')
        ->select('COUNT(b)')
        ->where('b.category = :category')
        ->setParameter('category', 'Science Fiction')
        ->getQuery()
        ->getSingleScalarResult(); 
}
public function countPublishedBooks()
{
    return $this->createQueryBuilder('b')
        ->select('COUNT(b)')
        ->where('b.published = :value')
        ->setParameter('value', 'yes')
        ->getQuery()
        ->getSingleScalarResult();
}
}
