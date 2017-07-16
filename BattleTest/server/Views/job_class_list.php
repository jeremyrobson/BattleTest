<h1>Job Classes</h1>

<table class="table">

<thead>

    <tr>
        <th>Name</th>
        <th>HP</th>
        <th>MP</th>
        <th>STR</th>
        <th>AGL</th>
        <th>MAG</th>
        <th>STA</th>
        <th>Move</th>
    </tr>

</thead>

<tbody>

<?php foreach ($job_classes as $job_class_id => $job_class): ?>

<tr>
    <td>
        <a href="index.php?page=jobclass&amp;action=view&amp;job_class_id=<?=$job_class->job_class_id?>">
            <?=$job_class->job_class_name;?>
        </a>
    </td>
    <td><?=$job_class->mod_hp;?></td>
    <td><?=$job_class->mod_mp;?></td>
    <td><?=$job_class->mod_str;?></td>
    <td><?=$job_class->mod_agl;?></td>
    <td><?=$job_class->mod_mag;?></td>
    <td><?=$job_class->mod_sta;?></td>
    <td><?=$job_class->mod_move;?></td>
</tr>

<?php endforeach; ?>

</tbody>

</table>