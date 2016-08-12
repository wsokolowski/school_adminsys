<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ClassSubject;
use AppBundle\Entity\Course;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/student")
 */
class StudentController extends Controller
{
    /**
     * @Route("/")
     * @Template("AppBundle:Student:welcome.html.twig")
     */
    public function welcomeAction(Request $request)
    {
        $student = $this->getUser();

        $course = $student->getCourse();

        $id = $course->getId();

        $classes = $this
            ->getDoctrine()
            ->getRepository('AppBundle:ClassSubject')
            ->findByCourse($id, array('date' => 'ASC'));

        return [
                'student' => $student,
                'course' => $course,
                'classes' => $classes
                ];
    }

}