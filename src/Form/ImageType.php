<?php

namespace App\Form;

use App\Entity\Image;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->effectif =$options['effectif'];
        $effectif = $this->effectif;

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
            //->add('flag', CheckboxType::class,['attr'=>['class'=>"custom-control-input"], 'required'=>false])
            ->add('effectif', EntityType::class,[
                'attr'=>['class'=>'form-control'],
                'class'=> 'App\Entity\Effectif',
                'query_builder' => function(EntityRepository $er) use($effectif){
                    return $er->findEffectif($effectif);
                },
                'choice_label' => 'id',
                'label' => '',
                'required'=>true,
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
            'effectif' => null,
        ]);
    }
}
