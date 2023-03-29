<?php

namespace Dotit\SyliusStorePlugin\Controller;

use Dotit\SyliusStorePlugin\Entity\Store;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

class StoreApiController extends AbstractController
{
    public function __invoke()
    {
        var_dump(true);
        die;
    }

}