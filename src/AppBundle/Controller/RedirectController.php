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
        return $this->redirect("/login");
    }

//    /**
//     * @Route("/all")
//     * @Template()
//     */
//    public function redirectAction()
//    {
//        return [
//            "users" => "/user",
//            "teachers" => "/teacher",
//            "students" => "/"
//        ];
//    }

}