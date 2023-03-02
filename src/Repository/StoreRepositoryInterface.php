<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Dotit\SyliusStorePlugin\Entity\storeInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface StoreRepositoryInterface extends RepositoryInterface
{
    public function createShopListQueryBuilder(
        ChannelInterface $channel,
        array $sorting = []
    ): QueryBuilder;

    public function findByEnabledQueryBuilder(?ChannelInterface $channel): QueryBuilder;

    public function findByChannel(ChannelInterface $channel): array;

    public function findOneBySlug(string $slug, string $locale): ?storeInterface;
}
