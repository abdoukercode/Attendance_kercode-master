<?php
/**
 * Created by PhpStorm.
 * User: abdou
 * Date: 01/10/2016
 * Time: 01:31
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */

    public function homepageAction()
    {
        $user= $this->getUser();
//        dump($user);
        return $this->render(':home:index.html.twig', [
            'user'=> $user

        ]);
    }


}

