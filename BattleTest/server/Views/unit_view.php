<?php

?>

<h1>Unit: <?=$unit->unit_name;?></h1>

<table class="table">
    <tbody>
        <tr>
            <th>Race</th>
            <td><?=$race->race_name;?></td>
        </tr>
        <tr>
            <th>Job Class</th>
            <td>
                <a href="index.php?page=jobclass&amp;action=view&amp;job_class_id=<?=$job_class->job_class_id?>">
                    <?=$job_class->job_class_name;?>
                </a>
            </td>
        </tr>
        <tr>
            <th>HP</th>
            <td><?=$unit->max_hp;?></td>
        </tr>
    </tbody>
</table>

<h2>Equipment</h2>

<?php
    include_once("equip.php");
?>