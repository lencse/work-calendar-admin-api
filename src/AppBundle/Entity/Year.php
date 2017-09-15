<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="years")
 */
class Year
{

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $year;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", name="is_active", nullable=false)
     */
    private $isActive = false;

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     * @return Year
     */
    public function setYear(int $year): Year
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return Year
     */
    public function setIsActive(bool $isActive): Year
    {
        $this->isActive = $isActive;
        return $this;
    }
}
