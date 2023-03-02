<?php

declare(strict_types=1);

namespace Tests\Dotit\SyliusStorePlugin\Behat\Page\Shop\Vendor;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface IndexPageInterface extends SymfonyPageInterface
{
    /**
     * @param int $pagesNumber
     * @return bool
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function hasPagesNumber(int $pagesNumber): bool;
}
