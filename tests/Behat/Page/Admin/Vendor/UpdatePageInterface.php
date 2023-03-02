<?php

declare(strict_types=1);

namespace Tests\Dotit\SyliusStorePlugin\Behat\Page\Admin\Vendor;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface as BaseUpdatePageInterface;
use Tests\Dotit\SyliusStorePlugin\Behat\Behaviour\ContainsErrorInterface;

interface UpdatePageInterface extends BaseUpdatePageInterface, ContainsErrorInterface
{
    /**
     * @param string $name
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillName(string $name): void;
}
