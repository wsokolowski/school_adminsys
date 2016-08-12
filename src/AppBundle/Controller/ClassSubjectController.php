<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ClassSubject;
use AppBundle\Form\ClassSubjectType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/teacher")
 */
class ClassSubjectController extends Controller
{

    /**
     * @Route("/courses/{id}/classes", name="course_classes")
     * @Method("GET")
     * @Template("AppBundle:ClassSubject:classes.html.twig")
     *
     */
    public function showCourseClassesAction(Request $request, $id)
    {
        $classes = $this
                    ->getDoctrine()
                    ->getRepository('AppBundle:ClassSubject')
                    ->findByCourse($id, array('date' => 'ASC'));

        if (!$classes) {
            throw $this->createNotFoundException('Unable to find ClassSubject entity.');
        }

        $course = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Course')
            ->findOneById($id);

        if (!$course) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }

        $entity = new ClassSubject();
        $form = $this->createForm(new ClassSubjectType(), $entity, array(
            'action' => $this->generateUrl('course_classes2', array('id' => $id)),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Add subject'));

        return [
                'classes' => $classes,
                'form' => $form->createView(),
                'course' => $course
                ];
    }

    /**
     * @Route("/courses/{id}/classes", name="course_classes2")
     * @Method("POST")
     * @Template("AppBundle:ClassSubject:classes.html.twig")
     */
    public function addClassToCourseAction(Request $request, $id)
    {
        $classes = $this
            ->getDoctrine()
            ->getRepository('AppBundle:ClassSubject')
            ->findByCourse($id, array('date' => 'ASC'));

        if (!$classes) {
            throw $this->createNotFoundException('Unable to find ClassSubject entity.');
        }

        $course = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Course')
            ->findOneById($id);

        if (!$course) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }

        $entity = new ClassSubject();
        $form = $this->createForm(new ClassSubjectType(), $entity, array(
            'action' => $this->generateUrl('course_classes2', array('id' => $id)),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Add subject'));
        $form->handleRequest($request);

        $entity->setCourse($course);

        if ($form->isValid()) {

            //decreases num of classes left
            $numOfClassLeft = $course->getNumOfClassesLeft();
            $course->setNumOfClassesLeft($numOfClassLeft-1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('course_classes', array('id' => $id)));
        }

        return array(
            'classes' => $classes,
            'form'   => $form->createView(),
            'course' => $course
        );
    }

    /**
     * @Route("/courses/classes/add", name="add_classes")
     * @Method("GET")
     * @Template("AppBundle:ClassSubject:addClasses.html.twig")
     */
    public function addClassAction(Request $request)
    {
        $entity = new ClassSubject();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ClassSubject entity.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ClassSubject $entity)
    {
        $form = $this->createForm(new ClassSubjectType(), $entity, array(
            'action' => $this->generateUrl('add_classes'),
            'method' => 'POST',
        ));

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        $teacher = $this->getUser();

        $form->add('course', 'entity', array(
            'class' => 'AppBundle:Course',
            'query_builder' => function (EntityRepository $er) use ($teacher) {
                return $er->createQueryBuilder('c')
                    ->where('c.teacher = :teacher')
                    ->setParameter('teacher', $teacher);
            },
            'choice_label' => function($course) {
                return $course->getType() . ' ' . $course->getLevel();
            },
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * @Route("/courses/classes/add", name="add_classes2")
     * @Method("POST")
     * @Template("AppBundle:ClassSubject:addClasses.html.twig")
     */
    public function createClassAction(Request $request)
    {
        $entity = new ClassSubject();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            //decreases num of classes left
            $course = $entity->getCourse();
            $numOfClassLeft = $course->getNumOfClassesLeft();
            $course->setNumOfClassesLeft($numOfClassLeft-1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('add_classes'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }




}