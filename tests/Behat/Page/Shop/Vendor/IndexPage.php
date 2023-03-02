<?php

declare(strict_types=1);

namespace Tests\Dotit\SyliusStorePlugin\Behat\Page\Shop\Vendor;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class IndexPage extends SymfonyPage implements IndexPageInterface
{
    /**
     * @inheritdoc
     */
    public function getRouteName(): string
    {
        return 'dotit_sylius_store_plugin_shop_vendor_index';
    }

    /**
     * @inheritdoc
     */
    public function hasPagesNumber(int $pagesNumber): bool
    {
        $vendorsList = $this->getElement('vendors');

        $vendorsNumberOnPage = count($vendorsList->findAll('css', '[data-test-vendor]'));

        return $pagesNumber == $vendorsNumberOnPage;
    }

    /**
     * @inheritdoc
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'vendors' => '[data-test-vendors]'
        ]);
    }
}
