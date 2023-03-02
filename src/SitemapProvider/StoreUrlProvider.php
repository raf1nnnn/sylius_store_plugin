<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\SitemapProvider;

use Doctrine\Common\Collections\Collection;
use Dotit\SyliusStorePlugin\Entity\storeInterface;
use Dotit\SyliusStorePlugin\Entity\storeTranslation;
use Dotit\SyliusStorePlugin\Repository\StoreRepositoryInterface;
use SitemapPlugin\Factory\UrlFactoryInterface;
use SitemapPlugin\Factory\AlternativeUrlFactoryInterface;
use SitemapPlugin\Model\ChangeFrequency;
use SitemapPlugin\Model\UrlInterface;
use SitemapPlugin\Provider\UrlProviderInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Model\TranslationInterface;
use Symfony\Component\Routing\RouterInterface;

final class StoreUrlProvider implements UrlProviderInterface
{
    private StoreRepositoryInterface $storeRepository;
    private RouterInterface $router;
    private UrlFactoryInterface $sitemapUrlFactory;
    private AlternativeUrlFactoryInterface $urlAlternativeFactory;
    private LocaleContextInterface $localeContext;
    private ChannelInterface $channel;

    public function __construct(
        StoreRepositoryInterface $storeRepository,
        RouterInterface $router,
        UrlFactoryInterface $sitemapUrlFactory,
        AlternativeUrlFactoryInterface $urlAlternativeFactory,
        LocaleContextInterface $localeContext
    ) {
        $this->storeRepository = $storeRepository;
        $this->router = $router;
        $this->sitemapUrlFactory = $sitemapUrlFactory;
        $this->urlAlternativeFactory = $urlAlternativeFactory;
        $this->localeContext = $localeContext;
    }

    public function getName(): string
    {
        return 'stores';
    }

    public function generate(ChannelInterface $channel): iterable
    {
        $this->channel = $channel;
        $urls = [];

        foreach ($this->getstores() as $store) {
            $urls[] = $this->createstoreUrl($store);
        }

        return $urls;
    }

    /**
     * @psalm-return Collection<array-key, TranslationInterface>
     */
    private function getTranslations(storeInterface $store): Collection
    {
        return $store->getTranslations()->filter(function (TranslationInterface $translation): bool {
            return $this->localeInLocaleCodes($translation);
        });
    }

    private function localeInLocaleCodes(TranslationInterface $translation): bool
    {
        return in_array($translation->getLocale(), $this->getLocaleCodes(), true);
    }

    private function getstores(): iterable
    {
        return $this->storeRepository->findByChannel($this->channel);
    }

    private function getLocaleCodes(): array
    {
        return $this->channel->getLocales()->map(function (LocaleInterface $locale): ?string {
            return $locale->getCode();
        })->toArray();
    }

    private function createstoreUrl(storeInterface $store): UrlInterface
    {
        $storeUrl = $this->sitemapUrlFactory->createNew('');

        $storeUrl->setChangeFrequency(ChangeFrequency::daily());
        $storeUrl->setPriority(0.7);

        if (null !== $store->getUpdatedAt()) {
            $storeUrl->setLastModification($store->getUpdatedAt());
        } elseif (null !== $store->getCreatedAt()) {
            $storeUrl->setLastModification($store->getCreatedAt());
        }

        /** @var storeTranslation $translation */
        foreach ($this->getTranslations($store) as $translation) {
            if (null === $translation->getLocale() || !$this->localeInLocaleCodes($translation)) {
                continue;
            }

            $location = $this->router->generate('dotit_sylius_store_plugin_shop_store_product_index', [
                'slug' => $store->getSlug(),
                '_locale' => $translation->getLocale(),
            ]);

            if ($translation->getLocale() === $this->localeContext->getLocaleCode()) {
                $storeUrl->setLocation($location);

                continue;
            }

            $storeUrl->addAlternative($this->urlAlternativeFactory->createNew($location, $translation->getLocale()));
        }

        return $storeUrl;
    }
}
