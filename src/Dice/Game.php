<?php

declare(strict_types=1);

namespace Rois\Dice;

use function Mos\Functions\{
    renderView,
    sendResponse,
    redirectTo,
    url
};

use Rois\Dice\DiceHand as diceHand;

class Game
{

    private $diceHand;
    private int $sum = 0;
    private ?string $result = null;

    /**
     * Generates a new dicehand and makes the first roll.
     * @return - void
     */
    public function playGame($dices): void
    {
        $this->diceHand = new diceHand(intval($dices));
        $this->diceHand->roll();
        $this->sum += $this->diceHand->sum();
    }

    /**
     * Makes a new roll of the dices.
     * @return - void
     */
    public function newRoll(): void
    {
        $this->diceHand->roll();
        $this->sum += $this->diceHand->sum();
    }

    /**
     * Make computer dice rolls and generate a result.
     * @return - void
     */
    public function stop($dices): void
    {
        $computerHand = new diceHand($dices);
        $computerSum = 0;
        while ($computerSum < 15) {
            $computerHand->roll();
            $computerSum += $computerHand->sum();
        }
        if ($computerSum >= $this->sum) {
            $this->result = "You lost! Computers score was: " . $computerSum;
        }
        $this->result = "You win! Computers score was: " . $computerSum;
    }

    /**
     * Getter to retrieve the dices.
     * @return array - The dice objects after latest roll.
     */
    public function getDices(): array
    {
        return $this->diceHand->getDices();
    }

    /**
     * Gets the values of the dices.
     * Getter to retrieve dice values.
     * @return array - The dice values from latest roll.
     */
    public function getValues(): array
    {
        return $this->diceHand->values();
    }

    /**
     * Geter to retrieve the sum of the dices from latest roll.
     * @return int - The sum of the latest dice roll.
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Getter to retrieve the generated result.
     * @return result - The generated game result.
     */
    public function getResult()
    {
        return $this->result;
    }
}
