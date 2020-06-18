<?php

namespace App\Form;

use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q1', CheckboxType::class,['attr'=>['class'=>"custom-control-input"], 'required'=>false])
            ->add('q2', CheckboxType::class,['attr'=>['class'=>"custom-control-input"], 'required'=>false])
            ->add('q3', CheckboxType::class,['attr'=>['class'=>"custom-control-input"], 'required'=>false])
            ->add('q4', CheckboxType::class,['attr'=>['class'=>"custom-control-input"], 'required'=>false])
            ->add('q5', CheckboxType::class,['attr'=>['class'=>"custom-control-input"], 'required'=>false])
            ->add('q6', CheckboxType::class,['attr'=>['class'=>"custom-control-input"], 'required'=>false])
            ->add('q7', CheckboxType::class,['attr'=>['class'=>"custom-control-input"], 'required'=>false])
            ->add('q8', CheckboxType::class,['attr'=>['class'=>"custom-control-input"], 'required'=>false])
            ->add('q9', CheckboxType::class,['attr'=>['class'=>"custom-control-input"], 'required'=>false])
            ->add('q10', CheckboxType::class,['attr'=>['class'=>"custom-control-input"], 'required'=>false])
            ->add('q11', CheckboxType::class,['attr'=>['class'=>"custom-control-input"], 'required'=>false])
            ->add('q12', CheckboxType::class,['attr'=>['class'=>"custom-control-input"], 'required'=>false])
            ->add('q13', CheckboxType::class,['attr'=>['class'=>"custom-control-input"], 'required'=>false])
            //->add('flag')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
