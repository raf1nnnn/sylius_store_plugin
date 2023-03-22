<?php

namespace Dotit\SyliusStorePlugin\Repository;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProvinceRepository as BaseProvinceRepository;

class ProvinceRepository extends BaseProvinceRepository
{
    public function findByName(string $name): ?ProvinceInterface
    {
        $qb = $this->createQueryBuilder('o');

        $qb
            ->andWhere('o.name = :name')
            ->setParameter('name', $name)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}