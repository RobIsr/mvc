<?php

use function Mos\Functions\url;

?>

<form method="POST" action="<?= url("/dice") ?>">
    <input type="submit" value="Play again" name="new_game">
</form>