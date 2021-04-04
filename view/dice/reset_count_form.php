<?php

use function Mos\Functions\url;

?>

<form method="POST" action="<?= url("/dice") ?>">
    <input type="submit" value="Reset Count" name="reset_count">
</form>