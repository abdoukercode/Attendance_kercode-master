<?php
/**
 * Created by PhpStorm.
 * User: abdou
 * Date: 07/10/2016
 * Time: 10:08
 */

namespace AppBundle\Repository;
use AppBundle\Entity\Student;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Presence;

class PresenceRepository extends EntityRepository
{
    /**
     * @param Student $student
     * @return Presence[]
     */
    public function findAllRecentPresenceForStudent(Student $student)
    {
        return $this->createQueryBuilder('student_presence')
            ->andWhere('student_presence.student = :student')
            ->setParameter('student', $student)
            ->setParameter('recentDate', new \DateTime('-3 months'))
            ->andWhere('student_presence.pointage > :recentDate' )
            ->orderBy('student_presence.pointage;', 'DESC')
            ->getQuery()
            ->execute();

    }

}



