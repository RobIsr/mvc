<?php

declare(strict_types=1);

namespace Rois\Dice;

class DiceHand
{
    /**
     * @var dices Array containing dices.
     * @var values Array containing dice roll values.
     */
    private array $dices;
    private array $values;

    /**
     * Constructor to initialize DeceHand with a number of Dices.
     * @var int $numDices - Number of dices.
     */
    public function __construct(int $numDices)
    {
        $this->dices = [];
        $this->values = [];

        for ($i = 0; $i < $numDices; $i++) {
            $this->dices[] = new GraphicalDice();
            $this->values[] = null;
        }
    }

    /**
     * Rolls all dices in the hand and save values.
     * @return void
     */
    public function roll(): void
    {
        $diceCount = count($this->dices);
        for ($i = 0; $i < $diceCount; $i++) {
            $this->dices[$i]->roll();
            $this->values[$i] = $this->dices[$i]->getLastRoll();
        }
    }

    /**
     * Get the values from all dices from last roll.
     * @return array - Array of resulting dice values from last roll.
     */
    public function values(): array
    {
        return $this->values;
    }

    /**
     * Calculate the sum of all values from last roll.
     * @return int - The sum of all dice values from last roll.
     */
    public function sum(): int
    {
        return array_sum($this->values);
    }

    /**
     * Calculates the average of all dice values from last roll.
     * @return float - The average of all dice values from last roll.
     */
    public function average(): float
    {
        return array_sum($this->values) / count($this->values);
    }

    public function getDices(): array
    {
        return $this->dices;
    }
}
