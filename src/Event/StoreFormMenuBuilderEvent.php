<?php

namespace Dotit\SyliusStorePlugin\Event;

use Dotit\SyliusStorePlugin\Entity\StoreInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
class StoreFormMenuBuilderEvent extends MenuBuilderEvent
{
    private StoreInterface $store;

    public function __construct(FactoryInterface $factory, ItemInterface $menu, StoreInterface $store)
    {
        parent::__construct($factory, $menu);

        $this->store = $store;
    }

    public function getStore(): StoreInterface
    {
        return $this->store;
    }
}