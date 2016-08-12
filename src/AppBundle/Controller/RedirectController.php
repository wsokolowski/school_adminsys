<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RedirectController extends Controller
{
    /**
     * @Route("/")
     */
    public function redirectAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $userRoles = $this->getUser()->getRoles();
        $userRole = $userRoles[0];

        if($userRole === "ROLE_STUDENT"){
            return $this->redirectToRoute('app_student_welcome');
        };

        if($userRole === "ROLE_TEACHER"){
            return $this->redirectToRoute('show_my_courses');
        };

        if($userRole === "ROLE_SUPER_ADMIN"){
            return $this->redirectToRoute('user');
        };

        return $this->redirect("/login");

    }

}