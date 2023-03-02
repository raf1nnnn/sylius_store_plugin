<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class DotitSyliusStorePlugin extends Bundle
{
    use SyliusPluginTrait;
}
