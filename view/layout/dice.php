<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

$header = $header ?? null;
$message = $message ?? null;

$diceHand = new \Rois\Dice\DiceHand();
$diceHand->roll();

$diceValues = $diceHand->values();

?><h1><?= $header ?></h1>

<p><?= $message ?></p>
<?php for($i = 0; $i < count($diceValues); $i++): ?>
    <p># <?= $i + 1 ?> -> <?= $diceValues[$i] ?></p>
<?php endfor; ?>
<p>Sum: <?= $diceHand->sum() ?></p>
<p>Average: <?= $diceHand->average() ?></p>
