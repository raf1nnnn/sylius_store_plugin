<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Dotit\SyliusStorePlugin\Entity\StoreInterface;
use Dotit\SyliusStorePlugin\Event\StoreFormMenuBuilderEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class StoreFormMenuBuilder
{
    private FactoryInterface $factory;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(FactoryInterface $factory, EventDispatcherInterface $eventDispatcher)
    {
        $this->factory = $factory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function createMenu(array $options = []): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        if (!array_key_exists('store', $options) || !$options['store'] instanceof StoreInterface) {
            return $menu;
        }

        $menu
            ->addChild('details')
            ->setAttribute('template', '@DotitSyliusStorePlugin/Admin/store/Tab/_details.html.twig')
            ->setLabel('sylius.ui.details')
            ->setCurrent(true)
        ;

        $menu
            ->addChild('media')
            ->setAttribute('template', '@DotitSyliusStorePlugin/Admin/store/Tab/_media.html.twig')
            ->setLabel('sylius.ui.media')
        ;

        $this->eventDispatcher->dispatch(
            new StoreFormMenuBuilderEvent($this->factory, $menu, $options['store'])
        );

        return $menu;
    }
}
