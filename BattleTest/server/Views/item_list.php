<?php
foreach ($party->items as $index => $item):
    $item_name = $index . ". " . $item->item_name;
?>

<tr>
    <td><a href="index.php?page=item&amp;action=view&amp;item_id=<?=$item->item_id?>"><?=$item_name?></a></td>
    <td><?=$item_classes[$item->item_class_id]->item_class_name?></td>
    <td><?=$item_types[$item->item_type_id]->item_type_name?></td>
    <td><?=$item_materials[$item->material_id]->material_name?></td>
    <td><?=$item_qualities[$item->quality_id]->quality_name?></td>
    <td><?=$item->_pow?></td>
    <td><?=$item->_def?></td>
</tr>

<a href="#" class="btn btn-md btn-danger float-right"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Drop Selected</a>

<?php
endforeach;
?>