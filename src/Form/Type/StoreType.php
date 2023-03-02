<?php

namespace Dotit\SyliusStorePlugin\Form\Type;
use Dotit\SyliusStorePlugin\Entity\StoreInterface;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class StoreType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('name', TextType::class, [
                'label' => 'sylius.ui.name',
            ])
            ->add('slug', TextType::class, [
                'label' => 'dotit_sylius_store_plugin.form.store.slug',
            ])
            ->add('address', TextType::class, [
                'label' => 'dotit_sylius_store_plugin.form.store.address',
            ])
            ->add('longitude', TextType::class, [
                'label' => 'dotit_sylius_store_plugin.form.store.longitude',
            ])
            ->add('latitude', TextType::class, [
                'label' => 'dotit_sylius_store_plugin.form.store.latitude',
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'sylius.ui.enabled',
            ])
            ->add('picking', CheckboxType::class, [
                'label' => 'dotit_sylius_store_plugin.form.store.picking',
            ])
            ->add('email', EmailType::class, [
                'label' => 'dotit_sylius_store_plugin.form.store.email',
            ])
            ->add('phoneNumber', IntegerType::class, [
                'label' => 'dotit_sylius_store_plugin.form.store.phoneNumber',
            ])
            ->add('logoFile', FileType::class, [
                'label' => 'dotit_sylius_store_plugin.form.store.logo',
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'validation_groups' => function (FormInterface $form): array {
                /** @var StoreInterface|null $store */
                $store = $form->getData();

                if (!$store instanceof StoreInterface || null === $store->getId()) {
                    return array_merge($this->validationGroups, ['dotit_logo_create']);
                }

                return $this->validationGroups;
            },
        ]);
    }
    public function getBlockPrefix(): string
    {
        return 'dotit_store';
    }
}