<?php
/**
 * Created by PhpStorm.
 * User: abdou
 * Date: 30/09/2016
 * Time: 21:16
 */

namespace AppBundle\Form\Type;

use AppBundle\Entity\Student;
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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PresenceType extends AbstractType
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
        /*->add('student', EntityType::class, array(
                'placeholder' => 'Select student',
                'class' => 'AppBundle:Student',
                'choice_label' => function ($student) {
                    return $student->getDisplayName();},
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('student_repository')
                        ->orderBy('student_repository.firstName', 'ASC');
                },
            ))*/

            ->add('Submit',SubmitType::class, array(
                'attr'=> [
                    'class'=> 'btn btn-success btn-lg'
                ]
            ))


            ;
    }


}