<table>
<tr>
    <td>Number</td>
    <td>Score</td>
</tr>
<tr>

<?php foreach ($rounds as $key => $value) :?>
    <tr>
        <td><?= $key ?></td>
        <td><?= $value ?></td>
    </tr>
<?php endforeach;?>
<tr>
    <td>Bonus:</td>
    <td><?= $bonus == 0 ? "-" : bonus; ?></td>
</tr>
<tr>
    <td>Total:</td>
    <td><?= $sum ?? "" ?></td>
</tr>
</table>