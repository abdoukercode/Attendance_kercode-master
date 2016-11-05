<?php
/**
 * Created by PhpStorm.
 * User: abdou
 * Date: 12/10/2016
 * Time: 19:26
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Formation;
use Doctrine\ORM\EntityRepository;

/**
 * @return Formation[]
 */

class FormationRepository extends EntityRepository
{
    public function findAllFormationOrderedByName()
    {
        return $this->createQueryBuilder('formation')
            ->findAll()
            ->orderBy('formation.name', 'ASC');

    }

}