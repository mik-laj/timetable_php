<?php

namespace TimetableBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/** @ORM\Embeddable()*/
class SimpleTime
{

    /**
     * @Assert\Range(
     *      min = 1,
     *      max = 24,
     * )
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="smallint")
     */
    private $hour;

    /**
     * @Assert\Range(
     *      min = 0,
     *      max = 60,
     * )
     * @Assert\NotBlank()
     *
     * @ORM\Column(type="smallint")
     */
    private $minute;

    /**
     * SimpleTime constructor.
     */
    public function __construct()
    {
        $argc = func_num_args();
        $argv = func_get_args();
        if ($argc == 1)
        {
            $minutes = $argv[0];
            $this->hour = ( $minutes / 60 ) | 0;
            $this->minute = $minutes % 60;
        } else if($argc == 2)
        {
            $this->hour = $argv[0];
            $this->minute = $argv[1];
        } else
        {
            // TODO: Throw error?
        }
    }



    /**
     * @return int
     */
    public function getHour()
    {
        return $this->hour;
    }

    /**
     * @param int $hour
     */
    public function setHour($hour)
    {
        $this->hour = $hour;
    }

    /**
     * @return int
     */
    public function getMinute()
    {
        return $this->minute;
    }

    /**
     * @param int $minute
     */
    public function setMinute($minute)
    {
        $this->minute = $minute;
    }

    public function __toString()
    {
        return sprintf('%02d:%02d', $this->hour, $this->minute);
    }
}