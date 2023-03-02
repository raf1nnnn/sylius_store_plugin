<?php

declare(strict_types=1);

namespace Tests\Dotit\SyliusStorePlugin\Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dotit\SyliusStorePlugin\Entity\VendorAwareInterface;
use Dotit\SyliusStorePlugin\Entity\VendorTrait;
use Sylius\Component\Core\Model\Product as BaseProduct;

/**
 * @ORM\Table(name="sylius_product")
 * @ORM\Entity
 */
class Product extends BaseProduct implements VendorAwareInterface
{
    use VendorTrait;
}
