<?php

?>

<h1>Equip: <?=$unit->unit_name;?></h1>

<form action="" method="post">
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="unit_id" value="<?=$unit->unit_id?>" />

    <table class="table">
        <tbody>

        <tr>
            <th></th>
            <th></th>
            <th>POW</th>
            <th>DEF</th>
            <th>HP</th>
            <th>MP</th>
            <th>STR</th>
            <th>AGL</th>
            <th>MAG</th>
            <th>STA</th>
            <th>ACC</td>
            <th>EVD</th>
            <th>MOVE</th>
            <th>RANGE</th>
        <tr>

        <tr>
            <th>Base</th>
            <td></td>
            <td><?=$base["pow"]?></td>
            <td><?=$base["def"]?></td>
        </tr>

        <?php foreach ($item_classes as $item_class_id => $item_class):
            $item = null;
            if (isset($unit->equip[$item_class_id])) {
                $item = $unit->equip[$item_class_id];
            }
        ?>

            <tr>
                <th><?=$item_class->item_class_name;?></th>
                <td>
                    <select name="equip[<?=$item_class_id?>]">
                        <option value="null">Nothing</option>
                        <?php foreach ($items as $item_id => $item):
                            $selected = "";
                            if (isset($unit->equip[$item_class_id])) {
                                $selected = ($unit->equip[$item_class_id] == $item_id) ? "selected" : "";
                            }
                        ?>
                            <option value="<?=$item_id?>" <?=$selected?>>
                                <?=$item->item_name?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><?=$item->_pow?></td>
                <td><?=$item->_def?></td>
                <td><?=$item->_pow?></td>
                <td><?=$item->_def?></td>
                <td><?=$item->_pow?></td>
                <td><?=$item->_def?></td>
                <td><?=$item->_pow?></td>
                <td><?=$item->_def?></td>
                <td><?=$item->_pow?></td>
                <td><?=$item->_def?></td>
                <td><?=$item->_pow?></td>
                <td><?=$item->_def?></td>
            </tr>

        <?php endforeach; ?>

            <tr>
                <th>Totals</th>
                <td></td>
                <td><?=$total["pow"]?></td>
                <td><?=$total["def"]?></td>
            </tr>

        </tbody>
    </table>

    <button type="submit" class="btn btn-lg btn-primary">Update</button>

</form>