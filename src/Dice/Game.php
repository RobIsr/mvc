<?php

declare(strict_types=1);

namespace Rois\Dice;

use function Mos\Functions\{
    renderView,
    sendResponse,
    redirectTo,
    url
};

class Game
{

    private $diceHand;
    private int $sum = 0;
    private ?string $result = null;

    /**
     * Generates a new dicehand and makes the first roll.
     * @return void
     */
    public function playGame($dices): void
    {
        $this->diceHand = new DiceHand($dices);
        $this->diceHand->roll();
        $this->sum += $this->diceHand->sum();
        $_SESSION["callable"] = serialize($this);
    }

    /**
     * Makes a new roll of the dices.
     * @return void
     */
    public function newRoll(): void
    {
        $this->diceHand->roll();
        $this->sum += $this->diceHand->sum();
        if ($this->sum > 21) {
            $this->result = "You lost!";
            $this->saveRound("computer");
        } elseif ($this->sum === 21) {
            $this->result = "You win!";
            $this->saveRound("player");
        }
        $_SESSION["callable"] = serialize($this);
        redirectTo(url("/dice/play"));
    }

    /**
     * Make computer dice rolls and generate a result.
     * @return void
     */
    public function stop(): void
    {
        $computerHand = new DiceHand(count($this->getDices()));
        $computerSum = 0;

        while ($computerSum < 15) {
            $computerHand->roll();
            $computerSum += $computerHand->sum();
        }

        if ($computerSum >= $this->sum && $computerSum <= 21) {
            $this->result = "You lost! Computers score was: " . $computerSum;
            $this->saveRound("computer");
            redirectTo(url("/dice/play"));
            $_SESSION["callable"] = serialize($this);
            return;
        }

        $this->result = "You win! Computers score was: " . $computerSum;
        $this->saveRound("player");
        $_SESSION["callable"] = serialize($this);
        redirectTo(url("/dice/play"));
    }

    /**
     * Getter to retrieve the dices.
     * @return array The dice objects after latest roll.
     */
    public function getDices(): array
    {
        return $this->diceHand->getDices();
    }

    /**
     * Gets the values of the dices.
     * Getter to retrieve dice values.
     * @return array The dice values from latest roll.
     */
    public function getValues(): array
    {
        return $this->diceHand->values();
    }

    /**
     * Getter to retrieve the sum of the dices from latest roll.
     * @return int The sum of the latest dice roll.
     */
    public function getSum(): int
    {
        return $this->sum;
    }

    /**
     * Getter to retrieve the generated result.
     * @return string The generated game result.
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Resets the round result counter.
     * @return void
     */
    public function resetRounds(): void
    {
        if (isset($_SESSION["player"])) {
            unset($_SESSION["player"]);
        }
        if (isset($_SESSION["computer"])) {
            unset($_SESSION["computer"]);
        }
    }

    /**
     * Saves the result of the played round to the session.
     * @return void
     */
    private function saveRound(string $winner): void
    {
        if (isset($_SESSION[$winner])) {
            $_SESSION[$winner] = $_SESSION[$winner] + 1;
            return;
        }
        $_SESSION[$winner] = 1;
        return;
    }
}
