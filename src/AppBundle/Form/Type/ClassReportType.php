<?php
/**
 * Created by PhpStorm.
 * User: abdou
 * Date: 12/10/2016
 * Time: 18:33
 */

namespace AppBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('formation', EntityType::class, array(
                'placeholder' => 'Select formation',
                'class' => 'AppBundle:Formation',
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('formation_repository')
                        ->orderBy('formation_repository.name', 'ASC');
                },
            ))
            ->add('debut', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'placeholder' => 'Select a value',


            ])
            ->add('fin', DateType::class, [
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'placeholder' => 'Select a value',
            ])
            ->add('Submit',SubmitType::class, array(
                'attr'=> [
                    'class'=> 'btn btn-success btn-lg'
                ]
            ))
            



        ;
    }


}



