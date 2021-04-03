<?php 
$gameObj = unserialize($_SESSION["callable"]);
$diceValues = $gameObj->getValues();
for($i = 0; $i < count($diceValues); $i++): ?>
    <i class="dice-sprite dice-<?= $diceValues[$i] ?>"></i>
<?php endfor; ?>
<p>Sum: <?= $gameObj->getSum() ?></p>
<h2><?= $gameObj->getResult() ?? "" ?></h2>
