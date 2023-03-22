<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\Uploader;

use Gaufrette\FilesystemInterface;
use Dotit\SyliusStorePlugin\Entity\storeInterface;
use Symfony\Component\HttpFoundation\File\File;

final class StoreLogoUploader implements StoreLogoUploaderInterface
{
    private FilesystemInterface $filesystem;

    public function __construct(
        FilesystemInterface $filesystem
    )
    {
        $this->filesystem = $filesystem;
    }

    public function upload(storeInterface $store): void
    {
        if ($store->getLogoFile() === null) {
            return;
        }
        /** @var File $file */
        $file = $store->getLogoFile();

        if (null !== $store->getLogoName() && $this->has($store->getLogoName())) {
            $this->remove($store->getLogoName());
        }
//        do {
//            $path = $this->name($file);
//        } while ($this->isAdBlockingProne($path) || $this->filesystem->has($path));
        $path = $this->name($file);

        $store->setLogoName($path);

        if ($store->getLogoName() === null) {
            return;
        }

        if (file_get_contents($file->getPathname()) === false) {
            return;
        }

        $this->filesystem->write(
            $store->getLogoName(),
            file_get_contents($file->getPathname()),
            true
        );
    }

    public function remove(string $path): bool
    {
        if ($this->filesystem->has($path)) {
            return $this->filesystem->delete($path);
        }

        return false;
    }

    private function has(string $path): bool
    {
        return $this->filesystem->has($path);
    }

    private function name(File $file): string
    {
        $name = \str_replace('.', '', \uniqid('', true));
        $extension = $file->guessExtension();


        if (\is_string($extension) && '' !== $extension) {
            $name = \sprintf('%s.%s', $name, $extension);
        }
        return $name;
    }

    private function isAdBlockingProne(string $path): bool
    {
        return strpos($path, 'ad') !== false;
    }
}
