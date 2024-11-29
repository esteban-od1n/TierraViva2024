<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class PositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add("0", HiddenType::class)->add("1", HiddenType::class);
        // $builder
        //     ->add("0", HiddenType::class, [
        //         "mapped" => false,
        //     ])
        //     ->add("1", HiddenType::class, [
        //         "mapped" => false,
        //     ]);
        //$builder->
        // $builder->addEventListener(FormEvents::PRE_SUBMIT, static function (FormEvent $ev) {
        //     dd($ev->getData());
        //     return "";
        // });
        // $builder->addEventListener(
        //     FormEvents::PRE_SUBMIT,
        //     static function (FormEvent $event) {
        //         $data = $event->getData();

        //         if (!\is_array($data)) {
        //             return;
        //         }

        //         foreach ($data as $v) {
        //             if (null !== $v && !\is_string($v) && !\is_int($v)) {
        //                 throw new TransformationFailedException(
        //                     "All choices submitted must be NULL, strings or ints."
        //                 );
        //             }
        //         }
        //     },
        //     256
        // );
    }

    public function buildView(FormView $view, FormInterface $interface, array $options): void
    {
    }
}
