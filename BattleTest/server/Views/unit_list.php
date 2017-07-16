<?php
foreach ($party->units as $index => $unit):
    $unit_name = $index . ". " . $unit->unit_name;
?>

<tr>
    <td><a href="index.php?page=unit&amp;action=view&amp;unit_id=<?=$unit->unit_id?>"><?=$unit_name?></a></td>
    <td><?=$races[$unit->race_id]->race_name?></td>
    <td><?=$job_classes[$unit->job_class_id]->job_class_name?></td>
    <td><a href="#" class="btn btn-md btn-danger float-right"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Remove</a></td>
</tr>

<?php
endforeach;
?>