<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\Entity;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

interface StoreTranslationInterface extends
    ResourceInterface,
    TranslationInterface,
    TimestampableInterface
{
    public function getDescription(): ?string;

    public function setDescription(?string $description): void;
}
