<?php

use function Mos\Functions\url;

?>

<form method="POST" action="<?= url("/dice/controls") ?>">
    <input type="submit" value="roll" name="roll">
    <input type="submit" value="stop" name="stop">
</form>