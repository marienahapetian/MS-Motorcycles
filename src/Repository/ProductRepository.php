<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    protected PaginatorInterface $paginator;
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Product::class);
        $this->paginator = $paginator;
    }

    public function findAllProducts(int $page, int $perpage = 15)
    {
        $query = $this->createQueryBuilder('p')->orderBy('p.id', 'DESC')
            ->getQuery();
        return $this->paginator->paginate($query, $page, $perpage);
    }

    public function searchByName(string $query): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->setMaxResults(10)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getAllByCategory(int $categoryId, int $limit = 10): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.categories', 'c')
            ->andWhere('c.id = :id')
            ->setParameter('id', $categoryId)
            ->setMaxResults($limit)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function searchLimited(string $query): array
    {
        return $this->searchQueryBuilder($query)->getResult();
    }

    public function searchQueryBuilder(string $query)
    {
        $qb = $this->createQueryBuilder('p');

        $qb
            ->leftJoin('p.brand', 'b')
            ->leftJoin('p.categories', 'c')

            ->andWhere(
                $qb->expr()->orX(
                    'LOWER(p.name) LIKE LOWER(:query)',
                    'LOWER(p.description) LIKE LOWER(:query)',
                    'LOWER(b.name) LIKE LOWER(:query)',
                    'LOWER(c.name) LIKE LOWER(:query)'
                )
            )

            ->setParameter('query', '%' . $query . '%')
            ->setMaxResults(6)
            ->distinct();

        return $qb->getQuery();
    }

    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
