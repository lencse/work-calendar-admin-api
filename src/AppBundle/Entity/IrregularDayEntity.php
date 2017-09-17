<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="irregular_days")
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
     * @ORM\Column(type="date", nullable=false, unique=true)
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
     * @return int
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return IrregularDayEntity
     */
    public function setId(string $id): IrregularDayEntity
    {
        $this->id = $id;
        return $this;
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
}
