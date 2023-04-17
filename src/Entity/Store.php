<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Product\Model\ProductInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Addressing\Model\Province;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;
use Symfony\Component\HttpFoundation\File\File;

class Store implements StoreInterface
{
    use TranslatableTrait {
        __construct as private initializeTranslationsCollection;
        getTranslation as private doGetTranslation;
    }
    use TimestampableTrait;
    use ToggleableTrait;

    protected ?int $id = null;
    protected ?string $name = null;
    protected ?string $slug = null;
    protected ?string $email = null;
    protected ?string $address = null;
    protected ?string $latitude = null;
    protected ?string $longitude = null;
    protected ?int $phoneNumber = null;
    private int $storeId;
    protected ?File $logoFile = null;
    protected ?string $logoName = null;
    protected ?int $position = null;
    protected ?string $logoPath = null;
    protected ?bool $picking = true;
    protected ?Province $province = null;
    /**
     * @psalm-var Collection<array-key, OrderInterface>
     */
    protected Collection $channels;

    /**
     * @psalm-var Collection<array-key, ProductInterface>
     */
    protected Collection $products;

    /**
     * @psalm-var Collection<array-key, ProductInterface>
     */
    protected Collection $orders;

    /**
     * @psalm-var Collection<array-key, StoreEmailInterface>
     */

    public function __construct()
    {
        $this->initializeTranslationsCollection();

        $this->channels = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        /** @var StoreTranslationInterface $StoreTranslation */
        $StoreTranslation = $this->getTranslation();

        return $StoreTranslation->getDescription();
    }

    public function setDescription(?string $description): void
    {
        /** @var StoreTranslationInterface $StoreTranslation */
        $StoreTranslation = $this->getTranslation();

        $StoreTranslation->setDescription($description);
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug = null): void
    {
        $this->slug = $slug;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setLogoFile(?File $file): void
    {
        $this->logoFile = $file;

        $this->setUpdatedAt(new \DateTime());
    }

    public function getLogoFile(): ?File
    {
        return $this->logoFile;
    }

    public function setLogoName(?string $logoName): void
    {
        $this->logoName = $logoName;
    }

    public function getLogoName(): ?string
    {
        return $this->logoName;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    public function getChannels(): Collection
    {
        return $this->channels;
    }

    public function hasChannel(ChannelInterface $channel): bool
    {
        return $this->channels->contains($channel);
    }

    public function addChannel(ChannelInterface $channel): void
    {
        if (!$this->hasChannel($channel)) {
            $this->channels->add($channel);

            if ($channel instanceof StoresAwareInterface) {
                $channel->addStore($this);
            }
        }
    }

    public function removeChannel(ChannelInterface $channel): void
    {
        if ($this->hasChannel($channel)) {
            $this->channels->removeElement($channel);

            if ($channel instanceof StoresAwareInterface) {
                $channel->removeStore($this);
            }
        }
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function getProvince(): ?Province
    {
        return $this->province;
    }

    public function setProvince(?Province $proivce)
    {
        $this->province = $proivce;
    }

    public function hasProduct(ProductInterface $product): bool
    {
        return $this->products->contains($product);
    }

    public function hasOrder(OrderInterface $order): bool
    {
        return $this->orders->contains($order);
    }

    public function addProduct(ProductInterface $product): void
    {
        if (!$this->hasProduct($product)) {
            $this->products->add($product);

            if ($product instanceof StoreAwareInterface) {
                $product->setStore($this);
            }
        }
    }

    public function addOrder(OrderInterface $order): void
    {
        if (!$this->hasOrder($order)) {
            $this->orders->add($order);

            if ($order instanceof StoreAwareInterface) {
                $order->setStore($this);
            }
        }
    }

    public function removeProduct(ProductInterface $product): void
    {
        if ($this->hasProduct($product)) {
            $this->products->removeElement($product);

            if ($product instanceof StoreAwareInterface) {
                $product->setStore(null);
            }
        }
    }

    public function removeOrder(OrderInterface $order): void
    {
        if ($this->hasProduct($order)) {
            $this->orders->removeElement($order);

            if ($order instanceof StoreAwareInterface) {
                $order->setStore(null);
            }
        }
    }

    public function getLogoPath(): string
    {
        return '/media/store-logo/' . $this->logoName;
    }


    protected function createTranslation(): TranslationInterface
    {
        return new StoreTranslation();
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getTranslation(?string $locale = null): TranslationInterface
    {
        // TODO: Implement getTranslation() method.
    }

    public function getPhoneNumber(): int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(int $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }

    public function setLatitude(?string $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function setLongitude(?string $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function getPicking(): bool
    {
        return $this->picking;
    }

    public function setPicking(bool $picking): void
    {
        $this->picking = $picking;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getStoreId()
    {
        return $this->id;
    }
}
