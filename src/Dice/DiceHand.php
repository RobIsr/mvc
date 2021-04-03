<?php

declare(strict_types=1);

namespace Rois\Dice;

class DiceHand {
    /**
     * @var dices - Array containing dices.
     * @var values - Array containing dice roll values.
     */
    private $dices;
    private $values;
    

    /**
     * Constructor to initialize DeceHand with a number of Dices.
     * @param int $dices - Number of dices.
     */
    public function __construct(int $dices) {
        $this->dices = [];
        $this->values = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[] = new GraphicalDice();
            $this->values[] = null;
        }
    }

    /**
     * Rolls all dices in the hand and save values.
     * @return void
     */
    public function roll() :void
    {
        for ($i = 0; $i < count($this->dices); $i++) {
            $this->dices[$i]->roll();
            $this->values[$i] = $this->dices[$i]->getLastRoll();
        }
    }

    /**
     * Get the values from all dices from last roll.
     * @return array - Array of resulting dice values from last roll.
     */
    public function values() :array
    {
        return $this->values;
    }

    /**
     * Calculate the sum of all values from last roll.
     * @return int - The sum of all dice values from last roll.
     */
    public function sum() :int
    {
        return array_sum($this->values);
    }

    /**
     * Calculates the average of all dice values from last roll.
     * @return float - The average of all dice values from last roll.
     */
    public function average() :float
    {
        return array_sum($this->values) / count($this->values);
    }

    public function getDices() {
        return $this->dices;
    }

}