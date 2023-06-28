<?php

namespace App\Repository;

use App\Entity\CarCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @extends ServiceEntityRepository<CarCategory>
 *
 * @method CarCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarCategoryRepository extends ServiceEntityRepository
{
    private $paginator;
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, CarCategory::class);
        $this->paginator = $paginator;
    }

    /**
     * @return CarCategory[]
     */
    public function findAll(): array
    {
        return $this->findBy(array(), array('name' => 'ASC'));
    }

    public function getAll(Request $request): PaginationInterface
    {
        return $pagination = $this->paginator->paginate($this->findAll(), $request->query->getInt('page', 1));
    }

    public function save(CarCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CarCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
