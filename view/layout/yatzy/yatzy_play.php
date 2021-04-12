<?php

/**
 * View template to show game view of yatzy game.
 */

declare(strict_types=1);

namespace Rois\Yatzy;

use function Mos\Functions\url;

require __DIR__ . "/../../header.php";


$header = $header ?? null;
$message = $message ?? null;
$rounds = $rounds ?? null;
$diceValues = $diceValues ?? null;
$savedValues = $savedValues ?? [];
$end = $end;
$saved = $saved;
$endGame = $endGame;
$sum = $sum;

?><h1><?= $header ?></h1>
<p><?= $message ?></p>

<?php require __DIR__ . "/../../yatzy/result_table.php"; ?>
<?php if (!$endGame) : ?>
    <h2>Saved Dices (Click to remove)</h2>

    <!-- Display dices saved by the user -->
    <div class="dices">
    <?php if (count($savedValues) > 0) : ?>
        <form id="dices" action="<?= url("/yatzy/controls") ?>" method="post">
            <?php foreach ($savedValues as $index => $value) : ?>
                <div class="dice-div">
                    <input class="dice-sprite dice-<?= $value ?>" type="submit" value="" name="<?= "rem-" . $index ?>">
                </div>
            <?php endforeach; ?>
        </form>
    <?php else : ?>
        <p><em>None selected yet...</em></p>
    <?php endif; ?>    
    </div>

    <h2>Rolled Dices (Click dices to save)</h2>

    <!-- Display dices from the last roll -->
    <div class="dices">
        <form id="dices" action="<?= url("/yatzy/controls") ?>" method="post">
            <?php foreach ($diceValues as $index => $value) : ?>
                <div class="dice-div">
                    <input class="dice-sprite dice-<?= $value ?>" type="submit" value="" name="<?= "add-" . $index ?>">
                </div>
            <?php endforeach; ?>
        </form>
    </div>
<?php endif; ?>

<?php if (!$end && !$endGame) : ?>
    <!-- New roll button -->
    <form method="POST" action="<?= url("/yatzy/controls") ?>">
        <input type="submit" value="Roll" name="roll">
    </form>
<?php endif ?>

<?php if ($end) : ?>
    <!-- Save and continue button -->
    <form method="POST" action="<?= url("/yatzy/controls") ?>">
        <select name="save_position" id="save_result">
            <option value="">Select target to store result</option>
            <?php for ($i = 1; $i <= count($rounds); $i++) :?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor;?>
        </select>
        <input type="submit" value="Save and continue" name="save_result">
    </form>
<?php endif; ?>

<?php if ($endGame) : ?>
    <form class="new-game-btn" method="POST" action="<?= url("/yatzy/controls") ?>">
        <input type="submit" value="Play Again" name="new_game">
    </form>
<?php endif; ?>


