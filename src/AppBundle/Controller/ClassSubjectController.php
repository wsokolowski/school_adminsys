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
     * @Route("/courses/{id}/classes", name="add_classes")
     * @Method("GET")
     * @Template("AppBundle:Teacher:showClasses.html.twig")
     */
    public function addClassToCourseAction(Request $request, $id)
    {

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