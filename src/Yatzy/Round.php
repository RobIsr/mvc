<?php

declare(strict_types=1);

namespace Rois\Yatzy;

use Rois\Dice\DiceHand;

class Round
{
    private $throwLimit;
    private DiceHand $diceHand;
    private array $storedDices = [];
    private int $throwCount = 0;
    private int $roundResult;
    private bool $end = FALSE;
    private bool $saved = FALSE;

    /**
     * Constructor to initialize the round.
     */
    public function __construct(int $throwLimit)
    {
        $this->throwLimit = $throwLimit;
        $this->diceHand = new DiceHand(5);
    }

    public function roll(): void
    {
        $this->saved = FALSE;
        $this->diceHand->roll();
        $this->throwCount++;
        if($this->throwCount === 3) {
            $this->end = TRUE;
        }
    }

    public function getDiceHand(): DiceHand
    {
        return $this->diceHand;
    }

    public function storeDices($index): void
    {
        array_push($this->storedDices, $this->diceHand->values()[$index]);
        $this->diceHand->spliceDice($index);
        
        $this->saved = TRUE;
    }

    public function removeDices($index): void
    {
        $this->diceHand->addDice($this->storedDices[$index]);
        array_splice($this->storedDices, $index, 1);
        $this->saved = TRUE;
    }

    public function getStoredDices(): array
    {
        return $this->storedDices;
    }

    public function checkSaved(): bool
    {
        return $this->saved;
    }

    public function checkEnd(): bool
    {
        return $this->end;
    }

    public function getRoundResult($value): int
    {
        $sum = 0;
        foreach($this->storedDices as $dice) {
            if ($dice === $value) {
                $sum += $dice;
            }
        }
        return $sum;
    }
}