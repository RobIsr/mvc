<?php

declare(strict_types=1);

namespace Rois\Yatzy;

use Rois\Yatzy\Round;

class YatzyGame
{
    const THROW_LIMIT = 3;
    private array $targets = array(
        1 => "",
        2 => "",
        3 => "",
        4 => "",
        5 => "",
        6 => ""
    );
    private int $roundCount = 1;
    private ?Round $currentRound = null;
    private bool $endGame = false;

    public function initGame(): void
    {
        $this->currentRound = new Round($this::THROW_LIMIT);
    }

    public function newRound(): void
    {
        $this->roundCount++;
        $this->currentRound = new Round($this::THROW_LIMIT);
    }

    public function saveRound($target, $test = false): void
    {
        if ($this->targets[$target] === "") {
            $this->targets[$target] = $this->currentRound->getRoundResult($target);
        }
        if ($test || $this->roundCount === 6) {
            $this->endGame = true;
        }
    }

    public function getRounds(): array
    {
        return $this->targets;
    }

    public function getCurrentRound(): Round
    {
        return $this->currentRound;
    }

    public function getRoundCount(): int
    {
        return $this->roundCount;
    }

    public function getTotalScore(): int
    {
        return array_sum(array_values($this->targets));
    }

    public function checkEndGame(): bool
    {
        return $this->endGame;
    }
}
