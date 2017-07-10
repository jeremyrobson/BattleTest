<h1>Party: <?=$party->party_name;?></h1>

<table class="table">
    <thead>
        <tr>
            <th>Unit Name</th>
            <th>Race</th>
            <td>Job Class</th>
            <th></th>
        </td>
    </thead>
    <tbody>

<?php
foreach ($party->units as $index => $unit):
?>

<tr>
    <td><a href="#"><?=$unit->unit_name?></a></td>
    <td><?=$races[$unit->race_id]->race_name?></td>
    <td><?=$job_classes[$unit->job_class_id]->job_class_name?></td>
    <td><a href="#" class="btn btn-md btn-danger float-right"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Remove</a></td>
</tr>

<?php
endforeach;
?>

    </tbody>
</table>

<a href="index.php?page=unit&amp;action=add&amp;party_id=<?=$party->party_id?>" class="btn btn-lg btn-primary">Create New Unit</a>