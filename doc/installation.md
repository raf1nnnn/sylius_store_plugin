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

9. update your order class by adding this code

use Dotit\SyliusStorePlugin\Entity\StoreInterface;

//
//
//
//

/**
     * @var StoreInterface|null
     *
     * @ORM\ManyToOne(targetEntity="Dotit\SyliusStorePlugin\Entity\StoreInterface")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $store;

    /**
     * @return StoreInterface|null
     */
    public function getStore(): ?StoreInterface
    {
        return $this->store;
    }

    /**
     * @param StoreInterface|null $store
     */
    public function setStore(?StoreInterface $store): void
    {
        $this->store = $store;
    }
```
```xml
* run  sudo cp  vendor/sylius/sylius/src/Sylius/Bundle/ApiBundle/Resources/config/api_resources/Order.xml  config/api_platform/
* add this code under order.xml :

            <itemOperation name="shop_select_store">
                <attribute name="method">PATCH</attribute>
                <attribute name="path">/shop/orders/{tokenValue}/store/{storeId}</attribute>
                <attribute name="messenger">input</attribute>
                <attribute name="input">Dotit\SyliusStorePlugin\Command\Checkout\ChooseStore</attribute>
                <attribute name="denormalization_context">
                    <attribute name="groups">shop:cart:select_store</attribute>
                </attribute>
                <attribute name="normalization_context">
                    <attribute name="groups">
                        <attribute>shop:order:read</attribute>
                        <attribute>shop:cart:read</attribute>
                    </attribute>
                </attribute>
                <attribute name="openapi_context">
                    <attribute name="summary">Selects store for a collect option</attribute>
                    <attribute name="parameters">
                        <attribute>
                            <attribute name="name">tokenValue</attribute>
                            <attribute name="in">path</attribute>
                            <attribute name="required">true</attribute>
                            <attribute name="schema">
                                <attribute name="type">string</attribute>
                            </attribute>
                        </attribute>
                        <attribute>
                            <attribute name="name">storeId</attribute>
                            <attribute name="in">path</attribute>
                            <attribute name="required">true</attribute>
                            <attribute name="schema">
                                <attribute name="type">string</attribute>
                            </attribute>
                        </attribute>
                    </attribute>
                </attribute>
            </itemOperation>

```
```xml
create a new file under /config/serlization named Order.xml
* add this code under order.xml :
        <?xml version="1.0" ?>

<serializer xmlns="http://symfony.com/schema/dic/serializer-mapping"
            xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
            xsi:schemaLocation="http://symfony.com/schema/dic/serializer-mapping https://symfony.com/schema/dic/serializer-mapping/serializer-mapping-1.0.xsd"
>
    <class name="Sylius\Component\Core\Model\Order">
        <attribute name="store">
            <group>admin:order:read</group>
            <group>shop:order:read</group>
            <group>shop:cart:read</group>
        </attribute>
    </class>
</serializer>


```
php bin/console d:s:u -f

php bin/console sylius:theme:assets:install

php bin/console cache:clear
```
