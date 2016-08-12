<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CourseRepository")
 */
class Course
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", length=255)
     */
    private $level;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_of_classes", type="integer")
     */
    private $numOfClasses;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_of_classes_left", type="integer")
     */
    private $numOfClassesLeft;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="courses")
     */
    private $teacher;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="course")
     */
    private $students;

    /**
     * @ORM\OneToMany(targetEntity="ClassSubject", mappedBy="course")
     */
    private $classSubjects;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Course
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

    /**
     * Set level
     *
     * @param string $level
     * @return Course
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set numOfClasses
     *
     * @param integer $numOfClasses
     * @return Course
     */
    public function setNumOfClasses($numOfClasses)
    {
        $this->numOfClasses = $numOfClasses;

        return $this;
    }

    /**
     * Get numOfClasses
     *
     * @return integer 
     */
    public function getNumOfClasses()
    {
        return $this->numOfClasses;
    }

    /**
     * Set numOfClassesLeft
     *
     * @param integer $numOfClassesLeft
     * @return Course
     */
    public function setNumOfClassesLeft($numOfClassesLeft)
    {
        $this->numOfClassesLeft = $numOfClassesLeft;

        return $this;
    }

    /**
     * Get numOfClassesLeft
     *
     * @return integer 
     */
    public function getNumOfClassesLeft()
    {
        return $this->numOfClassesLeft;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
        $this->classSubjects = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set teacher
     *
     * @param \AppBundle\Entity\User $teacher
     * @return Course
     */
    public function setTeacher(\AppBundle\Entity\User $teacher = null)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \AppBundle\Entity\User 
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Add students
     *
     * @param \AppBundle\Entity\User $students
     * @return Course
     */
    public function addStudent(\AppBundle\Entity\User $students)
    {
        $this->students[] = $students;

        return $this;
    }

    /**
     * Remove students
     *
     * @param \AppBundle\Entity\User $students
     */
    public function removeStudent(\AppBundle\Entity\User $students)
    {
        $this->students->removeElement($students);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * Add classSubjects
     *
     * @param \AppBundle\Entity\ClassSubject $classSubjects
     * @return Course
     */
    public function addClassSubject(\AppBundle\Entity\ClassSubject $classSubjects)
    {
        $this->classSubjects[] = $classSubjects;

        return $this;
    }

    /**
     * Remove classSubjects
     *
     * @param \AppBundle\Entity\ClassSubject $classSubjects
     */
    public function removeClassSubject(\AppBundle\Entity\ClassSubject $classSubjects)
    {
        $this->classSubjects->removeElement($classSubjects);
    }

    /**
     * Get classSubjects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClassSubjects()
    {
        return $this->classSubjects;
    }

    public function __toString()
    {
        return $this->type . " " . $this->level;
    }

}
