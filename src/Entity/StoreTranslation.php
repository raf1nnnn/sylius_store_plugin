<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\Entity;

use Sylius\Component\Resource\Model\AbstractTranslation;
use Sylius\Component\Resource\Model\TimestampableTrait;

class StoreTranslation extends AbstractTranslation implements StoreTranslationInterface
{
    use TimestampableTrait;

    protected ?int $id = null;
    protected ?string $description = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
