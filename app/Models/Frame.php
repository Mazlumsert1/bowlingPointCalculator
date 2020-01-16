<?php

namespace App\Models;


/**
 * Class Frame
 * @package App\Models
 */
class Frame
{
    /**
     * @var int
     */
    private $firstRoll;

    /**
     * @var int
     */
    private $secondRoll;

    /**
     * @var int
     */
    private $result = 0;

    /**
     * Frame constructor.
     * @param int $firstRoll |null
     * @param int $secondtRoll |null
     */
    public function __construct(int $firstRoll, int $secondtRoll)
    {
        $this->firstRoll = $firstRoll;
        $this->secondRoll = $secondtRoll;
    }


    /**
     * @return int
     */
    public function getFirstRoll(): int
    {
        return $this->firstRoll;
    }

    /**
     * @param int $firstRoll
     * @return Frame
     */
    public function setFirstRoll(int $firstRoll): Frame
    {
        $this->firstRoll = $firstRoll;
        return $this;
    }

    /**
     * @return int
     */
    public function getSecondRoll(): int
    {
        return $this->secondRoll;
    }

    /**
     * @param int $secondRoll
     * @return Frame
     */
    public function setSecondRoll(int $secondRoll): Frame
    {
        $this->secondRoll = $secondRoll;
        return $this;
    }

    /**
     * @return int
     */
    public function getResult(): int
    {
        return $this->result;
    }

    /**
     * @param int $result
     * @return Frame
     */
    public function setResult(int $result): Frame
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return bool
     */
    public function isStrike(): bool
    {
        return $this->firstRoll === 10 && $this->secondRoll === 0;
    }

    /**
     * @return bool
     */
    public function isSpare(): bool
    {
        return !$this->isStrike() && $this->firstRoll + $this->secondRoll === 10;
    }
}
