<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * OrganizationUnitRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class OrganizationUnitRepository extends NestedTreeRepository
{
    public function findAllQueryBuilder() {
        return $this->createQueryBuilder('unit');
    }

    public function findListQueryBuilder() {
        $qb = $this->findAllQueryBuilder();

        return $qb;
    }

    public function findWithJoins($id) {
        $qb = $this->findAllQueryBuilder();
        $qb->leftJoin('unit.parent', 'parent')->addSelect('parent');
        $qb->leftJoin('unit.fields', 'field')->addSelect('field');
        $qb->leftJoin('field.tutor', 'tutor')->addSelect('tutor');

        $qb->leftjoin('unit.rooms', 'room')->addSelect('room');

        $qb->where('unit.id = :id')->setParameter('id', $id);

        return $qb->getQuery()->getSingleResult();
    }
}
