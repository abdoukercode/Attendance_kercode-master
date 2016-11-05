<?php
/**
 * Created by PhpStorm.
 * User: abdou
 * Date: 07/10/2016
 * Time: 09:56
 */

namespace AppBundle\Entity;

use AppBundle\Entity\Student;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * @ORM\Entity
 * @ORM\Table(name="presence")
 */
class Presence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Student", inversedBy="presences")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="student_id")
     */
    private $student;


    /**
     * @ORM\Column(type="datetime")
     */
    public $pointage;

    public function __construct()
    {
        $this->pointage = new \DateTime();
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function setStudent(Student $student)
    {
        $this->student = $student;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPointage()
    {
        return $this->pointage;
    }

}