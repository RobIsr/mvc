<?php

declare(strict_types=1);

namespace Rois\Yatzy;

use Rois\Yatzy\Round;

class YatzyGame
{
    const THROW_LIMIT = 3;
    private array $targets = [
        1 => null,
        2 => null,
        3 => null,
        4 => null,
        5 => null,
        6 => null
    ];
    private int $roundCount = 1;
    private ?Round $currentRound = null;

    public function initGame(): void
    {
        $this->currentRound = new Round($this::THROW_LIMIT, $this->roundCount);
    }

    public function newRound(): void
    {
        //TODO: Implement logic to play a new round
    }

    public function saveRound(): void 
    {
        $this->targets[$roundCount] = $currentRound;
    }

    public function getRounds(): array
    {
        return $this->$targets;
    }

    public function getCurrentRound(): Round
    {
        return $this->currentRound;
    }
}