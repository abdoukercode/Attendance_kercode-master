<?php
/**
 * Created by PhpStorm.
 * User: abdou
 * Date: 12/10/2016
 * Time: 19:24
 */

namespace AppBundle\Controller\Admin;



use AppBundle\Entity\Formation;
use AppBundle\Form\Type\FormationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/admin")
 */
class FormationAdminController extends Controller
{
    /**
     * @Route("/formation", name="admin_formation_list")
     */
    public function IndexAction()

    {
        $formations = $this->getDoctrine()
            ->getRepository('AppBundle:Formation')
            ->findAll();
//dump($formations); die;
        return $this->render('Admin/formation/list-formation.html.twig', [
            'formations'=> $formations,



        ]);
    }

    /**
     * @Route("/formation/new", name="admin_formation_new")
     */
    public function newAction(Request $request)

    {
        $formation = new Formation();
        $form= $this->createForm(FormationType::class, $formation);
        // only handles data on POST
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $formation = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();


            $this->addFlash('success', 'You have just Created formation '.$formation->getName());

            return $this->redirectToRoute('admin_formation_list');

        }
        return $this->render('Admin/formation/new-formation.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/formation/{id}/edit", name="admin_formation_edit")
     */
    public function editAction(Request $request,Formation $formation)
    {



        $form = $this->createForm(FormationType::class, $formation);




        // only handles data on POST
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formation = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();

            $this->addFlash('success', 'Formation Updated - you are Amazing!');


            return $this->redirectToRoute('admin_formation_list');

        }


        return $this->render(':Admin/formation:edit-formation.html.twig', [
            'form' => $form->createView()

        ]);
    }


    /**
     * @Route("/formation/{id}/delete", name="admin_formation_delete")
     */

    public function DeleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $formation = $em->getRepository('AppBundle:Formation')->findOneBy(array('id' => $id));

        if (!$formation) {
            throw $this->createNotFoundException('No Formation found for id '.$id);
        }

        $em->remove($formation);
        $em->flush();

        return $this->redirectToRoute('admin_formation_list');

    }


}