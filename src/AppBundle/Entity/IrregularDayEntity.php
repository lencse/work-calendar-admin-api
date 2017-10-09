<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="irregular_days",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(columns={"is_published", "date"})
 *     },
 *     indexes={
 *         @ORM\Index(columns={"is_published"})
 *     }
 *  )
 */
class IrregularDayEntity
{

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", nullable=false, unique=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="type_key", length=40, nullable=false)
     */
    private $typeKey;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", name="is_published", nullable=false)
     */
    private $isPublished = false;

    /**
     * @return int
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return IrregularDayEntity
     */
    public function setDate(\DateTime $date): IrregularDayEntity
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeKey(): string
    {
        return $this->typeKey;
    }

    /**
     * @param string $typeKey
     * @return IrregularDayEntity
     */
    public function setTypeKey(string $typeKey): IrregularDayEntity
    {
        $this->typeKey = $typeKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description ?: '';
    }

    /**
     * @param string $description
     * @return IrregularDayEntity
     */
    public function setDescription(string $description): IrregularDayEntity
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param bool $isPublished
     * @return IrregularDayEntity
     */
    public function setIsPublished(bool $isPublished): IrregularDayEntity
    {
        $this->isPublished = $isPublished;
        return $this;
    }
}
