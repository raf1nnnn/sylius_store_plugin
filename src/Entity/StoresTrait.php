<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait StoresTrait
{
    protected Collection $Stores;

    public function __construct()
    {
        $this->Stores = new ArrayCollection();
    }

    public function getStores(): Collection
    {
        return $this->Stores;
    }

    public function hasStore(StoreInterface $Store): bool
    {
        return $this->Stores->contains($Store);
    }

    public function addStore(StoreInterface $Store): void
    {
        if (!$this->hasStore($Store)) {
            $this->Stores->add($Store);
        }
    }

    public function removeStore(StoreInterface $Store): void
    {
        if ($this->hasStore($Store)) {
            $this->Stores->removeElement($Store);
        }
    }
}
