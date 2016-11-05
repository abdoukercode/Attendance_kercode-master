<?php
/**
 * Created by PhpStorm.
 * User: abdou
 * Date: 05/10/2016
 * Time: 20:30
 */

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends BaseAdminController
{
//    /**
//     * @Route("/admin", name="admin_user_list")
//     */
//
//    public function adminListAction()
//    {
//        return $this->render(':EasyAdminBundle/views:list.html.twig');
//    }

    public function createNewUserEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function prePersistUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }


    public function preUpdateUserEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }
}