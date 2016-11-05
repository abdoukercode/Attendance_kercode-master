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
use AppBundle\Form\Type\ClassReportType;
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

class ClassReportController extends Controller
{


    /**
     * @Route("/report_class/new", name="admin_class-report_new")
     */


    public function newAction(Request $request)

    {


        $form= $this->createForm(ClassReportType::class);

        // only handles data on POST
        $form->handleRequest($request);



        $data= $form->getData();


        if ($form->isSubmitted() && $form->isValid()) {

            $formation=$data['formation'];
            $f_name= $formation->getName();

            $em = $this->getDoctrine()->getManager();
            $students = $em->getRepository('AppBundle:Student')
                ->findBy(['formation'=>$data['formation']]);

            $date_debut = $data['debut'];
            $date_fin = $data['fin'];

            /* $presences= $em->getRepository('AppBundle:Presence')
                 ->findBy(['student'=>$student])*/
            $repository = $this->getDoctrine()
                ->getRepository('AppBundle:Presence');


// createQueryBuilder automatically selects FROM AppBundle:Product
// and aliases it to "p"
            $query = $repository->createQueryBuilder('p')
                ->where('p.pointage BETWEEN :date_debut AND :date_fin')
                ->andWhere('p.student IN (:students)')
                ->setParameter('date_debut', $date_debut)
                ->setParameter('date_fin', $date_fin)
                ->setParameter('students', $students)
                ->orderBy('p.pointage', 'ASC')
                ->getQuery();

            $presences = $query->getResult();
            function returnBetweenDates($startDate, $endDate)
            {
                $startStamp = strtotime($startDate);
                $endStamp = strtotime($endDate);

                if ($endStamp > $startStamp) {
                    while ($endStamp >= $startStamp) {

                        $dateArr[] = date('Y-m-d', $startStamp);

                        $startStamp = strtotime(' +1 day ', $startStamp);

                    }
                    return $dateArr;
                } else {
                    return $startDate;
                }

            }

            $ranges = (returnBetweenDates($date_debut->format('Y-m-d'), $date_fin->format('Y-m-d')));
//$Pointages= $presences->getPointage();
            //dump($presences[1]->getPointage()->format('Y-m-d')); die;

            $Pointages = [];
            for ($i = 0; $i < count($presences); $i++) {

                array_push($Pointages, $exp = $presences[$i]->getPointage()->format('D d-M'));

            }

            $session = $request->getSession();
// set and get session attributes
            $session->set('$Sstudents', $students);
            $session->set('$Sranges', $ranges);
            $session->set('$Sdate_debut', $date_debut);
            $session->set('$Sdate_fin', $date_fin);
            $session->set('$SPointages', $Pointages);
            $session->set('$Sformation', $f_name);



            return $this->render(':Admin/report:report-class-details.html.twig', array(
                'students' => $students,
                'ranges' => $ranges,
                'debut' => $date_debut->format('D d-M-Y'),
                'fin' => $date_fin->format('D d-M-Y'),
                'Pointages' => $Pointages,
                'formation' => $f_name,
            ));










    }
$formation=$data['formation'];

        return $this->render('Admin/report/new-class_report.html.twig', [
            'form' => $form->createView(),
            'formation'=>$formation


        ]);
    }

    /**
     * @Route("/class-pdf-report", name="pdf-class-report")
     */
    public function indexPdfAction(Request $request)
    {
        $session = $request->getSession();

        $students = $session->get('$Sstudents');
        $ranges = $session->get('$Sranges');
        $date_debut = $session->get('$Sdate_debut');
        $date_fin = $session->get('$Sdate_fin');
        $Pointages = $session->get('$SPointages');
        $formation = $session->get('$Sformation');






        $snappy = $this->get('knp_snappy.pdf');

        $html = $this->renderView(':Admin/report:class-report-student_pdf.html.twig',array(



            'students' => $students,
            'ranges' => $ranges,
            'debut' => $date_debut->format('D d-M-Y'),
            'fin' => $date_fin->format('D d-M-Y'),
            'Pointages' => $Pointages,
            'formation' => $formation,
        ));


        $footer = $this->renderView(':Admin/report:pdf-class-footer.html.twig', array(
            'students' => $students,
            'ranges' => $ranges,
            'debut' => $date_debut->format('D,M Y'),
            'fin' => $date_fin->format('D,M Y'),
            'Pointages' => $Pointages,
            'formation' => $formation,
        ));
        $header = $this->renderView(':Admin/report:pdf-class-header.html.twig', array(
            'students' => $students,
            'ranges' => $ranges,
            'debut' => $date_debut->format('D,M Y'),
            'fin' => $date_fin->format('D,M Y'),
            'Pointages' => $Pointages,
            'formation' => $formation,
        ));
        $filename = $formation."'s". ' report';


        return new Response(
            $snappy->getOutputFromHtml($html,array(
                'footer-html' => $footer,
                'header-html'=> $header,
                'header-spacing' => '8',
                'header-font-name' => 'Times New Roman',
                'orientation' => 'landscape'
            )),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"',
                'orientation' => 'landscape'

            )
        );
    }


}