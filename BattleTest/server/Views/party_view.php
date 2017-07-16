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

    <?php include_once("unit_list.php"); ?>

    </tbody>
</table>

<a href="index.php?page=unit&amp;action=add&amp;party_id=<?=$party->party_id?>" class="btn btn-lg btn-primary">Create New Unit</a>