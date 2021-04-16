<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Item::class);
        $this->paginator = $paginator;
    }

    /**
     * @return Results
     */
    public function findLatest()
    {
        $query = $this->createQueryBuilder('i')
            ->orderBy('i.createdAt', 'DESC')
            ->setMaxResults(5)
        ;

        return $query->getQuery()->getResult();
    }

    /**
     * recupere tous les biens en lien avec une recherche
     * @return PaginationInterface
     */
    public function findSearch(SearchData $search): PaginationInterface
    {
        $query = $this
                    ->createQueryBuilder('i')
                    ->orderBy('i.id', 'DESC')
                ;
        
        if (!empty($search->getQ())) {
            $query = $query 
                    ->andWhere('i.title LIKE :q')
                    ->setParameter('q', "%{$search->getQ()}%")
            ;
        }
        
        $query = $query->getQuery();

        return $this->paginator->paginate(
            $query,
            $search->page,
            8
        );
    }

}
