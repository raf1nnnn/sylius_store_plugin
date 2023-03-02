<?php

namespace Dotit\SyliusStorePlugin\Menu;
use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        /** @var ItemInterface $item */
        $item = $menu->getChild('configuration');
        if (null == $item) {
            $item = $menu;
        }

        $item->addChild('Stores', ['route' => 'dotit_sylius_store_plugin_admin_store_index'])
            ->setLabel('dotit_sylius_store_plugin.menu.admin.stores')
            ->setLabelAttribute('icon', 'warehouse')
        ;
    }
}