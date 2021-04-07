<?php

declare(strict_types=1);

namespace Rois\Yatzy;

use Rois\Dice\DiceHand;

class Round
{
    private $throwLimit;
    private DiceHand $diceHand;
    private int $numberToStore;
    private array $storedDices;
    private int $throwCount;
    private int $roundResult;

    /**
     * Constructor to initialize the round.
     */
    public function __construct(int $throwLimit, int $numberToStore)
    {
        $this->throwLimit = $throwLimit;
        $this->numberToStore = $numberToStore;
        $this->diceHand = new DiceHand(5);
    }

    public function init_round(): void
    {
        //TODO: Implement logic to initialize the round.
    }

    public function roll(): DiceHand
    {
        $this->diceHand->roll();
    }

    public function storeDices(): void
    {
        //TODO: Implement logic to store selected dices.
    }

    public function getRoundResult(): int
    {
        //TODO: Return the sum of all the selected dices.
    }
}