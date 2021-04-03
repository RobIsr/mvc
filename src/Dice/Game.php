<?php

declare(strict_types=1);

namespace Rois\Dice;
use function Mos\Functions\{
    renderView,
    sendResponse,
    redirectTo,
    url
};

class Game {

    private $diceHand;
    private $sum = 0;
    private $result = null;

    public function playGame($dices): void
    {
        $data = [
            "header" => "Dice Game",
            "message" => "Try to get the the sum as close to 21 as possible, but not above...",
        ];

        $this->diceHand = new \Rois\Dice\DiceHand(intval($dices));
        $this->diceHand->roll();
        $this->sum += $this->diceHand->sum();
    }

    public function newRoll() {
        $data = [
            "header" => "Dice Game",
            "message" => "Try to get the the sum as close to 21 as possible, but not above...",
        ];
        $this->diceHand->roll();
        $this->sum += $this->diceHand->sum();
    }

    public function stop($dices) {
        $computerHand = new \Rois\Dice\DiceHand(intval($dices));
        $computerSum = 0;
        while($computerSum < 15) {
            $computerHand->roll();
            $computerSum += $computerHand->sum();
        }
        if ($computerSum >= $this->sum) {
            $this->result = "You lost! Computers score was: " . $computerSum;
        } else {
            $this->result = "You win! Computers score was: " . $computerSum;
        }

    }

    public function getDices() {
        return $this->diceHand->getDices();
    }

    public function getValues() {
        return $this->diceHand->values();
    }

    public function getSum() {
        return $this->sum;
    }

    public function getResult() {
        return $this->result;
    }

}