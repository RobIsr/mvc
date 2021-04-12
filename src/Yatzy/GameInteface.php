<?php

namespace Rois\Yatzy;

// Declare the interface 'iTemplate'
interface gameInterface
{
    public function init_game(): void;
    public function newRound(): void;
    public function saveRound($target): void;
}