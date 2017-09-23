<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="PublicationDataRepository")
 * @ORM\Table(name="publication_data")
 */
class PublicationData
{

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $id = 1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="publication_date", nullable=true)
     */
    private $publicationDate;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", name="is_draft", nullable=false)
     */
    private $isDraft = false;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getPublicationDate(): ?\DateTime
    {
        return $this->publicationDate;
    }

    /**
     * @param \DateTime $publicationDate
     * @return PublicationData
     */
    public function setPublicationDate(\DateTime $publicationDate): PublicationData
    {
        $this->publicationDate = $publicationDate;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDraft(): bool
    {
        return $this->isDraft;
    }

    /**
     * @param bool $isDraft
     * @return PublicationData
     */
    public function setIsDraft(bool $isDraft): PublicationData
    {
        $this->isDraft = $isDraft;
        return $this;
    }
}
