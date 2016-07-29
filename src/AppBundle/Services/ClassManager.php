<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;

class ClassManager
{
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function save($object, $is_flush = true)
    {
        $this->em->persist($object);
        if ($is_flush) {
            $this->em->flush();
        }
    }

    public function remove($object, $is_flush = true)
    {
        $this->em->remove($object);
        if ($is_flush) {
            $this->em->flush();
        }
    }
}