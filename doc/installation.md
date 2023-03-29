## Installation

1. Run `composer require dotit/sylius-store-plugin --no-scripts`

2. Enable the plugin in bundles.php

```php
<?php
// config/bundles.php

return [
    // ...
    Dotit\SyliusStorePlugin\DotitSyliusStorePlugin::class => ['all' => true],
];
```

3. Import the plugin configurations

```yml
# config/packages/_sylius.yaml
imports:
    # ...
    - { resource: "@DotitSyliusStorePlugin/Resources/config/config.yaml" }
```

4. Add the shop and admin routes

```yml
# config/routes.yaml
dotit_sylius_store_plugin_admin:
    resource: "@DotitSyliusStorePlugin/Resources/config/routing/admin.yaml"
    prefix: /admin

dotit_sylius_store_plugin_shop:
    resource: "@DotitSyliusStorePlugin/Resources/config/routing/shop.yaml"
    prefix: /{_locale}/stores
    requirements:
        _locale: ^[A-Za-z]{2,4}(_([A-Za-z]{4}|[0-9]{3}))?(_([A-Za-z]{2}|[0-9]{3}))?$
```

5. Include traits and override the models

```php
6.add api filters path under config/packages/api_platform.yaml:
api_platform:
    mapping:
        paths:
            - '%kernel.project_dir%/vendor/dotit/sylius-store-plugin/src/Resources/config/api_platform'
    patch_formats:
        json: ['application/merge-patch+json']
    swagger:
        versions: [3]




7. Create logo folder: run `mkdir public/media/store-logo -p` and insert a .gitkeep file in that folder

8. Finish the installation updating the database schema and installing assets

```
php bin/console d:s:u -f

php bin/console sylius:theme:assets:install

php bin/console cache:clear
```
