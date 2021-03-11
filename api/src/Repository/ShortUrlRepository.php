<?php

namespace App\Repository;

use App\Entity\ShortUrl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShortUrl|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShortUrl|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShortUrl[]    findAll()
 * @method ShortUrl[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShortUrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShortUrl::class);
    }

    public function save(ShortUrl $shortUrl): void
    {
        $this->_em->persist($shortUrl);
        $this->_em->flush();
    }

    public function findOneByShortcode($value): ?ShortUrl
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.code = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
