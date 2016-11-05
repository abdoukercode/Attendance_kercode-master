<?php
/**
 * Created by PhpStorm.
 * User: abdou
 * Date: 30/09/2016
 * Time: 21:16
 */

namespace AppBundle\Form\Type;


use AppBundle\Repository\FormationRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\HttpFoundation\File\File;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('firstName', TextType::class,  array('label' => 'FirstName') )
            ->add('lastName',TextType::class, array('label' => 'LastName'))
            ->add('email', EmailType::class, array('label' => 'Email') )
            ->add('formation', EntityType::class, array(
                'placeholder' => 'Select formation',
                'class' => 'AppBundle:Formation',
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('formation_repository')
                        ->orderBy('formation_repository.name', 'ASC');
                },
                ))

            ->add('imageFile', VichFileType::class, array(
                'label'         => 'profil Image',
                'required'      => false,
                'allow_delete'  => false, // not mandatory, default is true
                'download_link' => false, // not mandatory, default is true
            ))

            ->add('Submit',SubmitType::class, array(
                'attr'=> [
                    'class'=> 'btn btn-success btn-lg'
                ]
            ))


            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=>'AppBundle\Entity\Student'
        ]);

    }

}