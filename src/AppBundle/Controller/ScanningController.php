<?php
/**
 * Created by PhpStorm.
 * User: abdou
 * Date: 07/10/2016
 * Time: 11:14
 */

namespace AppBundle\Controller;
use AppBundle\Entity\Student;
use AppBundle\Entity\Presence;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ScanningController extends Controller
{
    /**
     * @Route("/scan/{student_id}", name="scan_Qr_Code")
     */


       public function scanAction($student_id)
    {
//        $product1 = new Product();
//        dump($product1);   die;


        $em = $this->getDoctrine()->getManager();


        $student= $em->getRepository('AppBundle:Student')->find($student_id);
        $presence = $em->getRepository('AppBundle:Presence')->findOneBy(['student'=>$student]);



        if(!$presence){
            $new_Presence= new Presence();
            $new_Presence->setStudent($student);

        } else {
        $new_Presence = clone $presence;
        }
        $new_Presence->pointage = new \DateTime();
        $em->persist($new_Presence);

        $em->flush();

        ;
        $presence->student_id=$student_id;


        $name= $student->getFirstName();
        return new Response(' Presence Validee pour ' .$name);
    }

}