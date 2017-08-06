<h1>Party: <?=$party->party_name;?></h1>

<table class="table">
    <thead>
        <tr>
            <th>Unit Name</th>
            <th>Race</th>
            <th>Job Class</th>
            <th></th>
        </td>
    </thead>
    <tbody>

    <?php include_once("unit_list.php"); ?>

    </tbody>
</table>

<a href="index.php?page=unit&amp;action=add&amp;party_id=<?=$party->party_id?>" class="btn btn-lg btn-primary">Create New Unit</a>

<?php include_once("item_list.php"); ?>

<a href="index.php?page=party&amp;action=create_random_item&amp;party_id=<?=$party->party_id?>" class="btn btn-lg btn-primary">Create Random Item</a>