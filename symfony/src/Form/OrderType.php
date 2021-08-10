<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Order;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('products', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('position', ChoiceType::class, [
                'choices'  => [
                    Order::POSITON_PENDING => Order::POSITON_PENDING,
                    Order::POSITON_SUCCESS => Order::POSITON_SUCCESS,
                    Order::POSITON_FAILED => Order::POSITON_FAILED
                ],
            ])

            ->add('billing_address_country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name'
            ])
            ->add('billing_address_address')
            ->add('billing_address_zip_code')
            ->add('billing_address_email')
            ->add('billing_address_phone')

            ->add('shipping_address_country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name'
            ])
            ->add('shipping_address_address')
            ->add('shipping_address_zip_code')
            ->add('shipping_address_email')
            ->add('shipping_address_phone')

            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary save'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
