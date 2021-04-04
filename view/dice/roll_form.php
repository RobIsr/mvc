<?php

use function Mos\Functions\url;

?>

<form method="POST" action="<?= url("/dice") ?>">
    <input type="submit" value="roll" name="roll">
    <input type="submit" value="stop" name="stop">
</form>