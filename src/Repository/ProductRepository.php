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

    public function findUsedCategories(): array
    {
        return $this->createQueryBuilder('p')
            ->select('DISTINCT c.id, c.name')
            ->join('p.categories', 'c')
            ->getQuery()
            ->getArrayResult();
    }

    public function findUsedBrands(): array
    {
        return $this->createQueryBuilder('p')
            ->select('DISTINCT b.id, b.name')
            ->join('p.brand', 'b')
            ->getQuery()
            ->getArrayResult();
    }

    public function findUsedColors(): array
    {
        return $this->createQueryBuilder('p')
            ->select('DISTINCT pf.id, pf.value')
            ->join('p.features', 'pf')
            ->join('pf.feature', 'f')
            ->where('f.name = :name')
            ->setParameter('name', 'Couleur')
            ->orderBy('pf.value', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }

    public function getMaxPrice(): ?int
    {
        return (int) $this->createQueryBuilder('p')
            ->select('MAX(p.price)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function createFilteredQuery(array $filters): array
    {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.categories', 'c')
            ->leftJoin('p.brand', 'b')
            ->leftJoin('p.features', 'pf')
            ->leftJoin('pf.feature', 'f');

        if (!empty($filters['categories'])) {
            $qb->andWhere('c.id IN (:categories)')
                ->setParameter('categories', $filters['categories']);
        }

        if (!empty($filters['brands'])) {
            $qb->andWhere('b.id IN (:brands)')
                ->setParameter('brands', $filters['brands']);
        }

        if (!empty($filters['colors'])) {
            $qb->andWhere('f.name = :featureName')
                ->andWhere('pf.value IN (:colors)')
                ->setParameter('featureName', 'couleur')
                ->setParameter('colors', $filters['colors']);
        }

        if (!empty($filters['prices'])) {

            $priceConditions = $qb->expr()->orX();

            foreach ($filters['prices'] as $key => $range) {

                if ($range === '20000+') {
                    $priceConditions->add('p.price >= 20000');
                    continue;
                }

                [$min, $max] = explode('-', $range);

                $paramMin = 'min_' . $key;
                $paramMax = 'max_' . $key;

                $priceConditions->add(
                    "p.price BETWEEN :$paramMin AND :$paramMax"
                );

                $qb->setParameter($paramMin, (int)$min);
                $qb->setParameter($paramMax, (int)$max);
            }

            $qb->andWhere($priceConditions);
        }

        return $qb
            ->distinct()
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult();
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
