<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class PublicationDataRepository extends EntityRepository
{

    /**
     * @return PublicationData
     */
    public function getPublicationData(): PublicationData
    {
        return $this->find(1);
    }
}
