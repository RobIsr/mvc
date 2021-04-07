<?php

use function Mos\Functions\url;

?>

<form method="POST" action="<?= url("/dice/controls") ?>">
    <input type="submit" value="Reset Count" name="reset">
</form>