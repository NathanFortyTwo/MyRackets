<?php

namespace App\Repository;

use App\Entity\RacketWeightCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RacketWeightCategory>
 *
 * @method RacketWeightCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method RacketWeightCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method RacketWeightCategory[]    findAll()
 * @method RacketWeightCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RacketWeightCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RacketWeightCategory::class);
    }

    public function add(RacketWeightCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RacketWeightCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return RacketWeightCategory[] Returns an array of RacketWeightCategory objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RacketWeightCategory
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
