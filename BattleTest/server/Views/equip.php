<?php
    //echo "<pre>"; print_r($unit); echo "</pre>";
?>
<table class="table">
    <tbody>

    <?php foreach ($item_classes as $item_class_id => $item_class):
        $item = null;
        if (isset($unit->equip[$item_class_id])) {
            $item = $unit->equip[$item_class_id];
        }
    ?>

        <tr>
            <th><?=$item_class->item_class_name;?></th>
            <td>
                <?php if (isset($item)): ?>
                    <a href="index.php?page=item&amp;action=view&amp;item_id=<?=$item->item_id?>">
                        <?=$item->item_name;?>
                    </a>
                <?php else: ?>
                    (Nothing)
                <?php endif; ?>
            </td>
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>