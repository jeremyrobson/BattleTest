<h1>Parties</h1>

<table class="table">
    <thead>
        <tr>
            <th>Party Name</th>
            <th>Gold</th>
            <th>Unit Count</th>
            <th></th>
        </td>
    </thead>
    <tbody>

<?php
foreach ($parties as $index => $party):
    $party_name = $index . ". " . $party->party_name
?>

<tr>
    <td>
        <a href="index.php?page=party&amp;action=view&amp;party_id=<?=$party->party_id?>">
            <?=$party_name?>
        </a>
    </td>
    <td><?=$party->gold?></td>
    <td><?=count($party->units);?></td>
    <td><a href="#" class="btn btn-md btn-danger float-right"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Remove</a></td>
</tr>

<?php
endforeach;
?>

    </tbody>
</table>

<a href="index.php?page=party&amp;action=add" class="btn btn-lg btn-primary">Create New Party</a>