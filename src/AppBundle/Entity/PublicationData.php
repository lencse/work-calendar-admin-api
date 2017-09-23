<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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
     * @ORM\Column(type="date", name="publish_date")
     */
    private $publishDate;

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
    public function getPublishDate(): \DateTime
    {
        return $this->publishDate;
    }

    /**
     * @param \DateTime $publishDate
     * @return PublicationData
     */
    public function setPublishDate(\DateTime $publishDate): PublicationData
    {
        $this->publishDate = $publishDate;
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
