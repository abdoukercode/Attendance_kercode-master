<?php
/**
 * Created by PhpStorm.
 * User: abdou
 * Date: 13/10/2016
 * Time: 09:47
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Formation;
use AppBundle\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Annotation\Route;

class FormationController extends Controller
{
    /**
     * @Route("/formation-list" , name="formation-list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $formations= $em->getRepository('AppBundle:Formation')
            ->findAll();


        return $this->render('formation/list-formation.html.twig', [
            'formations' => $formations,

        ]);
    }

    /**
     * @Route("/formation/{id}" , name="formation-show")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $formation = $em->getRepository('AppBundle:Formation')
            ->findOneBy(['id' => $id]);

        if (!$formation) {
            throw $this->createNotFoundException('Formation not found');
        }

        $students = $em->getRepository('AppBundle:Student')
            ->findBy(['formation'=>$formation]);




//dump($formation);die;

        return $this->render('formation/show-formation.html.twig', [
            'students' => $students,
            'formation'=> $formation

        ]);
    }

    /**
     * @Route("/formation/{student_id}", name="formation-student-show")
     */
    public function showStudentAction($student_id)
    {
        $em = $this->getDoctrine()->getManager();

        $student = $em->getRepository('AppBundle:Student')
            ->findOneBy(['student_id' => $student_id]);

        if (!$student) {
            throw $this->createNotFoundException('student not found');
        }
        $message= "http://aaebb3e1.ngrok.io/scan/$student_id";

        $formation = $em->getRepository('AppBundle:Formation')
            ->findOneBy(['id' => $student->getFormation()]);
        $f_name= $formation->getName();
//dump($f_name);die;
        return $this->render('formation/show-student.html.twig', array(
            'student' => $student,
            'message'=> $message,
            'formation'=>$f_name
        ));
    }


}