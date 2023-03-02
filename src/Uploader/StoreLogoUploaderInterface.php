<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\Uploader;

use Dotit\SyliusStorePlugin\Entity\storeInterface;

interface storeLogoUploaderInterface
{
    public function upload(storeInterface $store): void;

    public function remove(string $path): bool;
}
