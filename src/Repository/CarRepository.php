<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    private $paginator;
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Car::class);
        $this->paginator = $paginator;
    }

    /**
     * @return Car[]
     */
    public function findAll(): array
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }

    public function getAll(Request $request, string $sortOrder): PaginationInterface
    {
        $qb = $this->createQueryBuilder('c')
        ->select('c')
        ->join('c.category', 'cat')
        ->where('cat.id = c.category')
        ->orderBy('c.name', 'ASC')
        ->orderBy('cat.name', $sortOrder);
        $query = $qb->getQuery();
        return $pagination = $this->paginator->paginate($query->execute(), $request->query->getInt('page', 1));
    }

    public function findByName(Request $request, string $search, string $sortOrder): PaginationInterface
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c')
            ->join('c.category', 'cat')
            ->where('c.name like :name AND cat.id = c.category')
            ->setParameter('name', '%'.$search.'%')
            ->orderBy('c.name', 'ASC')
            ->orderBy('cat.name', $sortOrder);
        $query = $qb->getQuery();

        return $pagination = $this->paginator->paginate($query->execute(), $request->query->getInt('page', 1));
    }

    public function save(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
