<?php

/**
 * View template to show starting page of yatzy game.
 */

declare(strict_types=1);

namespace Rois\Yatzy;

use function Mos\Functions\url;

require __DIR__ . "/../../header.php";


$header = $header ?? null;
$message = $message ?? null;
?><h1><?= $header ?></h1>
<p><?= $message ?></p>

<form method="POST" action="<?= url("/yatzy/controls") ?>">
    <input type="submit" value="Start Game" name="start">
</form>
