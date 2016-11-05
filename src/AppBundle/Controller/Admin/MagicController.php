<?php
/**
 * Created by PhpStorm.
 * User: abdou
 * Date: 18/10/2016
 * Time: 10:33
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Formation;
use AppBundle\Entity\Presence;
use AppBundle\Entity\Student;
use AppBundle\Form\Type\MagicType;
use AppBundle\Form\Type\PresenceType;
use AppBundle\Form\Type\ReportType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;




/**
 * @Route("/admin")
 */

class MagicController extends Controller
{



    /**
     * @Route("/magic/new", name="admin_magic_new")
     */


    public function newMagicAction(Request $request)

    {


        $form= $this->createForm(PresenceType::class);
        // only handles data on POST
        $form->handleRequest($request);

        $data= $form->getData();
        if ($form->isSubmitted() && $form->isValid()) {

            $formation=$data['formation'];

            $em = $this->getDoctrine()->getManager();
            $students = $em->getRepository('AppBundle:Student')
                ->findBy(['formation'=>$data]);

//dump($students); die;


            return $this->render('Admin/report/magic.html.twig', [
                'form' => $form->createView(),
                'students'=>$students,
                'formation'=>$formation
            ]);
        }
$formation=$data['formation'];

        return $this->render('Admin/report/magic.html.twig', [
            'form' => $form->createView(),
            'formation'=>$formation


        ]);
    }

    /**
     * @Route("/magic/{student_id}", name="magic-student-show")
     */
    public function showMagicStudentAction(Request $request, $student_id)
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


        $form= $this->createForm(MagicType::class);
        // only handles data on POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $date = $data['date'];
            $presence = $em->getRepository('AppBundle:Presence')->findOneBy(['student'=>$student]);



            if(!$presence){
                $new_Presence= new Presence();
                $new_Presence->setStudent($student);

            } else {
                $new_Presence = clone $presence;
            }
            $new_Presence->pointage = $date;
            $em->persist($new_Presence);

            $em->flush();

            ;
            $presence->student_id=$student_id;


            $name= $student->getFirstName();
            return new Response(' Presence Validee pour ' .$name);
        }

        return $this->render(':Admin/report:magic-show-student.html.twig', array(
            'student' => $student,
            'message'=> $message,
            'formation'=>$f_name,
            'form' => $form->createView()
        ));


    }










}