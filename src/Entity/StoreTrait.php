<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\Entity;

trait StoreTrait
{
    protected ?StoreInterface $Store = null;

    public function getStore(): ?StoreInterface
    {
        return $this->Store;
    }

    public function setStore(?StoreInterface $Store): void
    {
        $this->Store = $Store;
    }
}
