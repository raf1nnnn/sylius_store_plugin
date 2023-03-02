<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\Entity;

use Doctrine\Common\Collections\Collection;

interface StoresAwareInterface
{
    /**
     * @psalm-return Collection<array-key, StoreInterface>
     */
    public function getStores(): Collection;

    public function hasStore(StoreInterface $Store): bool;

    public function addStore(StoreInterface $Store): void;

    public function removeStore(StoreInterface $Store): void;
}
