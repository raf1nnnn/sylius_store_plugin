<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\Repository;

use Doctrine\ORM\QueryBuilder;
use Dotit\SyliusStorePlugin\Entity\storeInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\ChannelInterface;

class StoreRepository extends EntityRepository implements StoreRepositoryInterface
{
    public function createShopListQueryBuilder(
        ChannelInterface $channel,
        array $sorting = []
    ): QueryBuilder {
        return $this->findByEnabledQueryBuilder($channel);
    }

    public function findByEnabledQueryBuilder(?ChannelInterface $channel): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('enabled', true)
        ;

        if ($channel instanceof ChannelInterface) {
            $queryBuilder->innerJoin('o.channels', 'channel')
                ->andWhere('channel = :channel')
                ->setParameter('channel', $channel)
            ;
        }

        return $queryBuilder;
    }

    public function findByChannel(ChannelInterface $channel): array
    {
        return $this->findByEnabledQueryBuilder($channel)->getQuery()->getResult();
    }

    public function findOneBySlug(string $slug, string $locale): ?storeInterface
    {
        return $this->createQueryBuilder('o')
            ->addSelect('translation')
            ->innerJoin('o.translations', 'translation')
            ->andWhere('o.slug = :slug')
            ->andWhere('o.enabled = true')
            ->andWhere('translation.locale = :locale')
            ->setParameter('slug', $slug)
            ->setParameter('locale', $locale)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
