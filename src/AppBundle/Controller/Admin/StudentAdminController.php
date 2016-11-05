<?php
/**
 * Created by PhpStorm.
 * User: abdou
 * Date: 01/10/2016
 * Time: 01:35
 */

namespace AppBundle\Controller\Admin;
use AppBundle\Entity\Formation;
use AppBundle\Entity\Student;
use AppBundle\Form\Type\StudentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
*/
class StudentAdminController extends Controller
{
    /**
     * @Route("/student", name="admin_student_list")
     */
    public function IndexAction()

    {
        $students= $this->getDoctrine()
            ->getRepository('AppBundle:Student')
            ->findAll();
//dump($students); die;
        return $this->render('Admin/student/list-student.html.twig', [
            'students'=> $students,



        ]);
    }

    /**
     * @Route("/student/new", name="admin_student_new")
     */
        public function newAction(Request $request)

    {

        $student = new Student();
        $form= $this->createForm(StudentType::class, $student);
        // only handles data on POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $student = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();


            $this->addFlash('success', 'You have just Created student '.$student->getfirstname());

            return $this->redirectToRoute('admin_student_list');

        }
        return $this->render('Admin/student/new-student.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
 * @Route("/student/{student_id}/edit", name="admin_student_edit")
 */
    public function editAction(Request $request,Student $student, $student_id)
    {



        $form = $this->createForm(StudentType::class, $student);




        // only handles data on POST
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            $this->addFlash('success', 'Student Updated - you are Amazing!');


            return $this->redirectToRoute('admin_student_list');

    }
        $message= "http://99fafb33.ngrok.io/scan/$student_id";

        return $this->render(':Admin/student:edit-student.html.twig', [
            'form' => $form->createView(),
            'student'=>$student,
            'message'=>$message,

        ]);
    }

    /**
     * @Route("/student/{student_id}/delete", name="admin_student_delete")
     */

    public function DeleteAction($student_id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $student = $em->getRepository('AppBundle:Student')->findOneBy(array('student_id' => $student_id));

        if (!$student) {
            throw $this->createNotFoundException('No Student found for id '.$student_id);
        }

        $em->remove($student);
        $em->flush();

        return $this->redirectToRoute('admin_student_list');

    }
}