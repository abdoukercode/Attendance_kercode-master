<?php
/**
 * Created by PhpStorm.
 * User: blessing_Codes
 * Date: 28/10/2016
 * Time: 19:26
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class KnpExampleController extends Controller

{
    /**
     * @Route("/knp-demo", name="knp-demo")
     */
    /*public function indexAction()
    {
        $snappy = $this->get('knp_snappy.pdf');
        $name = 'myFirstSnappyPDF';
        $url = 'http://sfr.fr';


        return new Response(
            $snappy->getOutput($url),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$name.'.pdf"'
            )
        );
    }*/
    /*public function indexAction()
    {
        $snappy = $this->get('knp_snappy.pdf');

        $html = '<h1>Hello</h1>';

        $filename = 'myFirstSnappyPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );
    }*/
    public function indexAction()
    {
        $snappy = $this->get('knp_snappy.pdf');

        $html = '<h1>Hello</h1>';

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