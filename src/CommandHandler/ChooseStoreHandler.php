<?php

namespace Dotit\SyliusStorePlugin\CommandHandler;

use Dotit\SyliusStorePlugin\Command\Checkout\ChooseStore;
use Dotit\SyliusStorePlugin\Entity\StoreInterface;
use Dotit\SyliusStorePlugin\Repository\StoreRepository;
use SM\Factory\FactoryInterface;
use Sylius\Bundle\ApiBundle\Changer\PaymentMethodChangerInterface;
use Dotit\SyliusStorePlugin\Command\Checkout\ChoosePaymentMethod;
use Sylius\Bundle\ApiBundle\Command\IriToIdentifierConversionAwareInterface;
use Sylius\Bundle\ApiBundle\Command\OrderTokenValueAwareInterface;
use Sylius\Bundle\ApiBundle\Command\PaymentMethodCodeAwareInterface;
use Sylius\Bundle\ApiBundle\Command\SubresourceIdAwareInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\PaymentMethodInterface;
use Sylius\Component\Core\OrderCheckoutTransitions;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\PaymentMethodRepositoryInterface;
use Sylius\Component\Core\Repository\PaymentRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Webmozart\Assert\Assert;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;


/** @experimental */
final class ChooseStoreHandler implements MessageHandlerInterface
{
    private OrderRepositoryInterface $orderRepository;
    private StoreRepository $storeRepository;
    private $entityManager;
    public function __construct(
        OrderRepositoryInterface         $orderRepository,
        EntityManagerInterface $entityManager,
        StoreRepository  $storeRepository

    )
    {
        $this->orderRepository = $orderRepository;
        $this->entityManager = $entityManager;
        $this->storeRepository = $storeRepository;



    }

    public function __invoke(ChooseStore $chooseStore)
    {
        $cart = $this->orderRepository->findOneBy(['tokenValue' => $chooseStore->orderTokenValue]);

        Assert::notNull($cart, 'Cart has not been found.');

        $storeId = $chooseStore->storeId;
        $store = $this->storeRepository->findOneBy(['id'=>$storeId]);
        if(!$store instanceof StoreInterface){
            return new JsonResponse('Store not found',404);
        }

        $cart->setStore($store);
        $this->entityManager->persist($store);
        $this->entityManager->flush();
        return $cart;
    }
}
