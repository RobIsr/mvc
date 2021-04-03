<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

require __DIR__ . "/../header.php";
$gameObj = unserialize($_SESSION["callable"]) ?? null;
$header = $header ?? null;
$message = $message ?? null;
?><h1><?= $header ?></h1>
<p><?= $message ?></p>



<?php
    require __DIR__ . "/../dice/game.php";
    if (is_null($gameObj->getResult())) {
        require __DIR__ . "/../dice/roll_form.php";
    } else {
        require __DIR__ . "/../dice/reset_form.php";
    }
    
?>