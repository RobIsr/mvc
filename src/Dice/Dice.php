<?php

declare(strict_types=1);

namespace Rois\Dice;

class Dice {
    const DICE_FACES = 6;
    private $rollResult = 0;

    public function roll(): int
    {
        $this->rollResult = rand(1, self::DICE_FACES);

        return $this->rollResult;
    }

    public function getLastRoll(): int
    {
        return $this->rollResult;
    }
}