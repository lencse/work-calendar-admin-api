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
     * @ORM\Column(type="boolean", name="is_enabled", nullable=false)
     */
    private $isEnabled = false;

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
    public function isEnabled(): bool
    {
        return $this->isEnabled;
    }

    /**
     * @param bool $isEnabled
     * @return Year
     */
    public function setIsEnabled(bool $isEnabled): Year
    {
        $this->isEnabled = $isEnabled;
        return $this;
    }
}
