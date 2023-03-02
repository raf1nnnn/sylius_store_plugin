<?php

namespace Dotit\SyliusStorePlugin\EventListener;

use Dotit\SyliusStorePlugin\Entity\StoreInterface;
use Dotit\SyliusStorePlugin\Uploader\StoreLogoUploaderInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;



final class StoreLogoUploadListener
{
    private StoreLogoUploaderInterface $uploader;

    public function __construct(StoreLogoUploaderInterface $uploader)
    {
        $this->uploader = $uploader;
    }

    public function uploadLogo(GenericEvent $event): void
    {
        $store = $event->getSubject();
        Assert::isInstanceOf($store, StoreInterface::class);

        $this->uploader->upload($store);
    }
}