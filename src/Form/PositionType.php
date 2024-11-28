<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
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
        $builder->addEventListener(FormEvents::PRE_SUBMIT, static function (FormEvent $ev) {
            dd($ev->getData());
        });
    }

    // public function buildView(FormView $view, FormInterface $interface, array $options): void
    // {
    //     dd($view);
    // }
}
