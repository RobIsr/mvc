<?php

declare(strict_types=1);

namespace Rois\Dice;

class Dice {
    private $sides = 6;
    protected $rollResult = 0;

    /**
     * Constructor to initialize the dice with all 6 sides.
     */
    public function __construct(int $diceSides)
    {
       $this->sides = $diceSides;
    }

    public function roll(): int
    {
        $this->rollResult = rand(1, $this->sides);

        return $this->rollResult;
    }

    public function getLastRoll(): int
    {
        return $this->rollResult;
    }
}