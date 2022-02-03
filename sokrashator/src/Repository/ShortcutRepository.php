<?php

namespace App\Repository;

use App\Entity\Shortcut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Shortcut|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shortcut|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shortcut[]    findAll()
 * @method Shortcut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortcutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shortcut::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findOneByCodeOrAlias(string $value): ?Shortcut
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.code = :code')
            ->orWhere('s.alias = :alias')
            ->setParameter('code', $value)
            ->setParameter('alias', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
