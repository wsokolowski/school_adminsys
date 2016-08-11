<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="teacher")
     */
    protected $courses;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="students")
     */
    protected $course;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     * @Assert\Choice({"ROLE_STUDENT", "ROLE_TEACHER", "ROLE_SUPER_ADMIN"})
     *
     */
    protected $type;

    /**
     * Add courses
     *
     * @param \AppBundle\Entity\Course $courses
     * @return User
     */
    public function addCourse(\AppBundle\Entity\Course $courses)
    {
        $this->courses[] = $courses;

        return $this;
    }

    /**
     * Remove courses
     *
     * @param \AppBundle\Entity\Course $courses
     */
    public function removeCourse(\AppBundle\Entity\Course $courses)
    {
        $this->courses->removeElement($courses);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * Set course
     *
     * @param \AppBundle\Entity\Course $course
     * @return User
     */
    public function setCourse(\AppBundle\Entity\Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \AppBundle\Entity\Course 
     */
    public function getCourse()
    {
        return $this->course;
    }

    public function removeRoles()
    {
        $this->roles = [];

        return $this;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
}
