<?php

namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('username')
            ->add('email', 'email')
            ->add('plainPassword')
            ->add('roles', 'choice',
                [
                    'choices' => [
//                        'ROLE_SUPER_ADMIN' => 'admin',
                        'ROLE_TEACHER' => 'teacher',
                        'ROLE_STUDENT' => 'student'
                    ],
                    'mapped' => false
                ])
            ->add('course')
        ;
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_user_registration';
    }
}
