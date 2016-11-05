<?php
/**
 * Created by PhpStorm.
 * User: abdou
 * Date: 30/09/2016
 * Time: 21:05
 */

namespace AppBundle\Controller;

use AppBundle\Repository\FormationRepository;
use AppBundle\Entity\Formation;
use AppBundle\Form\Type\StudentType;
use AppBundle\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class StudentsController extends Controller

{
    /**
     * @Route("/students-list" , name="student-list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $students= $em->getRepository('AppBundle:Student')
            ->findAll();


        return $this->render('student/students-list.html.twig', [
            'students' => $students,

        ]);
    }

    /**
     * @Route("/student/{student_id}", name="student-show")
     */
    public function showAction($student_id)
    {
        $em = $this->getDoctrine()->getManager();

        $student = $em->getRepository('AppBundle:Student')
            ->findOneBy(['student_id' => $student_id]);

        if (!$student) {
            throw $this->createNotFoundException('student not found');
        }
        $message= "http://99fafb33.ngrok.io/scan/$student_id";

        $formation = $em->getRepository('AppBundle:Formation')
            ->findOneBy(['id' => $student->getFormation()]);
        $f_name= $formation->getName();
//dump($f_name);die;
        return $this->render('student/show-student.html.twig', array(
            'student' => $student,
            'message'=> $message,
            'formation'=>$f_name
        ));
    }

    /**
     * @Route("/send-student-info/{student_id}", name="send-student_info")
     */
    public function sendInfoAction($student_id)
    {
        $em = $this->getDoctrine()->getManager();

        $student = $em->getRepository('AppBundle:Student')
            ->findOneBy(['student_id' => $student_id]);

        if (!$student) {
            throw $this->createNotFoundException('student not found');
        }
        $Qrmessage= "http://99fafb33.ngrok.io/scan/$student_id";

        $formation = $em->getRepository('AppBundle:Formation')
            ->findOneBy(['id' => $student->getFormation()]);
        $f_name= $formation->getName();

        $message = \Swift_Message::newInstance()
            ->setSubject('Hello Email')
            ->setFrom('SayhelloAdmin@kercode.com')
            ->setTo($student->getEmail())
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    'Emails/student.html.twig',
                    array(
                        'student' => $student,
                        'message'=>$Qrmessage,
                        'student_id'=>$student_id
                    )
                ),
                'text/html'
            )
            ->attach(\Swift_Attachment::fromPath('favicon.ico'))
            ->addPart('<p>This part of the message has been formatted as HTML to make it look nicer </p>', 'text/html')



        ;


            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'Emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;

        $this->get('mailer')->send($message);
        $this->addFlash('success', 'You have sent info to student '.$student->getfirstname());

        return $this->redirectToRoute('student-show',array(
            'student' => $student,
            'message'=> $Qrmessage,
            'formation'=>$f_name,
            'student_id'=>$student_id
        ));

/*//dump($f_name);die;
        return $this->render('student/show-student.html.twig', array(
            'student' => $student,
            'message'=> $message,
            'formation'=>$f_name
        ));*/
    }

    /**
     * @Route("/pdf-info/{student_id}", name="pdf-info-report")
     */

    public function indexAction(Request $request, $student_id)
    {
        $em = $this->getDoctrine()->getManager();

        $student = $em->getRepository('AppBundle:Student')
                        ->findOneBy(['student_id' => $student_id]);

        $formation = $em->getRepository('AppBundle:Formation')
            ->findOneBy(['id' => $student->getFormation()]);
        $f_name= $formation->getName();

        $Qrmessage= "http://99fafb33.ngrok.io/scan/$student_id";
        $snappy = $this->get('knp_snappy.pdf');


        $html = $this->renderView(':Emails:qr.html.twig',array(
            'student'=>$student,
            'formation'=>$f_name,
            'student_id'=>$student_id,
            'message'=>$Qrmessage
        ));

        $filename = 'myFirstSnappyPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="'.$filename.'.pdf"'
            )
        );
    }



}