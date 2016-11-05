<?php
/**
 * Created by PhpStorm.
 * User: abdou
 * Date: 01/10/2016
 * Time: 01:49
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Student;
use Doctrine\ORM\EntityRepository;

/**
 * @return Student[]
 */
class StudentRepository extends EntityRepository
{
    public function findAllStudentOrderedByStudentId()
    {
        return $this->createQueryBuilder('student')
            ->leftJoin('student.presences', 'student_pointage')
            ->orderBy('student.presences', 'ASC');

    }

}

