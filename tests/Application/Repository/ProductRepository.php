<?php

declare(strict_types=1);

namespace Tests\Dotit\SyliusStorePlugin\Application\Repository;

use Dotit\SyliusStorePlugin\Repository\ProductRepositoryInterface;
use Dotit\SyliusStorePlugin\Repository\ProductRepositoryTrait;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductRepository as BaseProductRepository;

class ProductRepository extends BaseProductRepository implements ProductRepositoryInterface
{
    use ProductRepositoryTrait;
}
