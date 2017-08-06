<h2>Inventory</h2>

<table class="table">
    <thead>
        <th><input type="checkbox" /></th>
        <th>Name</th>
        <th>Class</th>
        <th>Type</th>
        <th>Material</th>
        <th>Quality</th>
        <th>Range</th>
        <th>Move</th>
        <th>POW</th>
        <th>DEF</th>
        <th>ACC</th>
        <th>EVD</th>
        <th>HP</th>
        <th>MP</th>
        <th>STR</th>
        <th>AGL</th>
        <th>MAG</th>
        <th>STA</th>
        <th>Price</th>
    </thead>
    <tbody>

<?php
foreach ($party->items as $index => $item):
    $item_name = $index . ". " . $item->item_name;
    $item_link = "index.php?page=item&amp;action=view&amp;item_id=" . $item->item_id;
?>

<tr>
    <td><input type="checkbox" /></td>
    <td><a href="<?=$item_link?>"><?=$item_name?></a></td>
    <td><?=$item_classes[$item->item_class_id]->item_class_name?></td>
    <td><?=$item_types[$item->item_type_id]->item_type_name?></td>
    <td><?=$item_materials[$item->material_id]->item_material_name?></td>
    <td><?=$item_qualities[$item->quality_id]->item_quality_name?></td>
    <td><?=$item->_pow?></td>
    <td><?=$item->_def?></td>
</tr>

<?php
endforeach;
?>

    </tbody>
</table>

<a href="#" class="btn btn-md btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Drop Selected</a>
<div class="clearfix"></div>
<br>