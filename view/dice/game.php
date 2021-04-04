<?php
$gameObj = unserialize($_SESSION["callable"]);
$diceValues = $gameObj->getValues();?>

<div class="round-count">
    <h3>Rounds won: </h3>
    <p><b>You: </b><?= $_SESSION["player"] ?? "0" ?> <b>Computer: </b><?= $_SESSION["computer"] ?? "0" ?></p>
    <?php require __DIR__ . "/../dice/reset_count_form.php"; ?>
</div>

<?php for ($i = 0; $i < count($diceValues); $i++) : ?>
    <i class="dice-sprite dice-<?= $diceValues[$i] ?>"></i>
<?php endfor; ?>

<p>Sum: <?= $gameObj->getSum() ?></p>
<h2><?= $gameObj->getResult() ?? "" ?></h2>
