<?php

namespace Dotit\SyliusStorePlugin\Block;
use Sonata\BlockBundle\Event\BlockEvent;
use Sonata\BlockBundle\Model\Block;
final class StoreJsBlockListener
{
    public function onBlockEvent(BlockEvent $event): void
    {
        $template = '@DotitSyliusStorePlugin/Admin/store/_store_js.html.twig';

        $block = new Block();
        $block->setId(uniqid('', true));
        $block->setSettings(array_replace($event->getSettings(), [
            'template' => $template,
        ]));
        $block->setType('sonata.block.service.template');

        $event->addBlock($block);
    }
}