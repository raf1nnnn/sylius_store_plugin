<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Dotit\SyliusStorePlugin\Entity\storeInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ChannelInterface;

class StoreRepository extends EntityRepository implements StoreRepositoryInterface
{
    public function findByProvinceId($provinceId)
    {
        return $this->createQueryBuilder('store')
            ->join('store.province', 'province')
            ->where('province.id = :provinceId')
            ->setParameter('provinceId', $provinceId)
            ->getQuery()
            ->getResult();
    }
}
