<?php

namespace App\Categories\Infrastructure;

use App\Categories\Domain\Category;
use App\Categories\Domain\CategoryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DoctrineCategory>
 *
 * @method DoctrineCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method DoctrineCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method DoctrineCategory[]    findAll()
 * @method DoctrineCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineCategory::class);
    }

    public function add(DoctrineCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(DoctrineCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function save(Category $category): void
    {
        $doctrineCategory = new DoctrineCategory();
        $doctrineCategory->name = $category->getName();
        $this->getEntityManager()->persist($doctrineCategory);
        $this->getEntityManager()->flush();
    }

    public function findByName(string $name): ?Category
    {
        $doctrineCategory = $this->findOneBy(['name' => $name]);
        if (!$doctrineCategory) {
            return null;
        }

        return new Category($doctrineCategory->name, $doctrineCategory->id);
    }

//    /**
//     * @return DoctrineCategory[] Returns an array of DoctrineCategory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DoctrineCategory
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
