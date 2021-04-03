<?php
    use function Mos\Functions\url;
    ?>
    <form method="POST" action="<?= url("/dice") ?>">
    <label for="dices">Select number of dices</label>
    <select name="dices" id="dices">
        <option value="1">1</option>
        <option value="2">2</option>
    </select>

    <button type="submit" value="submit">Start game</button>
</form>