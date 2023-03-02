<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\Controller;

use Sylius\Component\Product\Generator\SlugGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class StoreSlugController
{
    private SlugGeneratorInterface $slugGenerator;

    public function __construct(SlugGeneratorInterface $slugGenerator)
    {
        $this->slugGenerator = $slugGenerator;
    }

    public function generate(Request $request): Response
    {
        /** @var string $name */
        $name = $request->query->get('name');

        return new JsonResponse([
            'slug' => $this->slugGenerator->generate($name),
        ]);
    }
}
