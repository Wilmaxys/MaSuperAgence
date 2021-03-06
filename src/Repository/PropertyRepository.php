<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     * @param PropertySearch $search search object
     * @return Query query use for pagination
     */
    public function findAllVisible(PropertySearch $search): Query
    {
        $query = $this->findAllVisibileQuery();

        if ($search->getMaxPrice())
        {
            $query = $query->andWhere('p.price < :maxPrice')
                ->setParameter('maxPrice', $search->getMaxPrice());
        }

        if ($search->getMinSurface())
        {
            $query = $query->andWhere('p.surface > :minSurface')
                ->setParameter('minSurface', $search->getMinSurface());
        }

        if ($search->getTags()->count() > 0) {
            $k = 0;
            foreach ($search->getTags() as $tag){
                $query = $query
                    ->andWhere(":tag$k MEMBER OF p.tags")
                    ->setParameter("tag$k", $tag);
                $k++;
            }
        }

        return $query->getQuery();
    }

    /**
     * @return Property[]
     */
    public function findLatest(): array
    {
        return $this->findAllVisibileQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return QueryBuilder return the query builder for all the visible properties
     */
    private function findAllVisibileQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
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
    public function findOneBySomeField($value): ?Property
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
