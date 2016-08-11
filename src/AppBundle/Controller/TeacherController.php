<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * @Route("/teacher")
 */
class TeacherController extends Controller
{
    /**
     * @Route("/courses", name="show_my_courses")
     * @Method("GET")
     * @Template("AppBundle:Teacher:show.html.twig")
     */
    public function showMyCoursesAction(Request $request)
    {
        $teacherId = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();

        $courses = $em->getRepository('AppBundle:Course')->findByTeacher($teacherId);

        return [ 'courses' => $courses ];
    }

    /**
     * @Route("/courses/{id}/students", name="show_course_students")
     * @Method("GET")
     * @Template("AppBundle:Teacher:students.html.twig")
     */
    public function showCourseStudentsAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $students = $em->getRepository('AppBundle:User')->findByCourse($id);

        return [ 'students' => $students ];
    }

}
