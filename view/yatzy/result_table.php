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
    <td>Total:</td>
    <td><?= $sum ?? "" ?></td>
</tr>
</table>