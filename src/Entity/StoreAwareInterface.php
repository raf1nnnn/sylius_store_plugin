<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\Entity;

interface StoreAwareInterface
{
    public function getStore(): ?StoreInterface;

    public function setStore(?StoreInterface $Store): void;
}
