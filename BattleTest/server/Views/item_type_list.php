<h1>Item Types</h1>
<div class="row">
    <div class="col-md-6">
        <table class="table">
            <thead>
                <tr>
                    <th>Item Type Name</th>
                    <th>Item Class Name</th>
                    <th>Item Materials</th>
                    <th>Job Classes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($item_types as $item_type_id => $item_type):
                ?>
                <tr>
                    <td>
                        <?=$item_type->item_type_name?>
                    </td>
                    <td>
                        <?=$item_classes[$item_type->item_class_id]->item_class_name?>
                    </td>
                    <td>
                        <select multiple="multiple" class="form-control">
                            <?php
                                foreach ($materials as $item_material_id => $material):
                                    $id = "item_material_$item_material_id";
                                    $name = $material->item_material_name;
                                    $selected = in_array($item_material_id, array_keys($item_type->item_materials)) ? "selected" : "";
                            ?>
                                <option id="<?=$id?>" value="<?=$item_material_id?>" <?=$selected?> ><?=$name?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </td>
                    <td>
                        <select multiple="multiple" class="form-control">
                            <?php
                                foreach ($job_classes as $job_class_id => $job_class):
                                    $id = "job_class_$job_class_id";
                                    $name = $job_class->job_class_name;
                                    $selected = in_array($job_class_id, array_keys($item_type->job_classes)) ? "selected" : "";
                            ?>
                                <option id="<?=$id?>" value="<?=$job_class_id?>" <?=$selected?> ><?=$name?></option>
                            <?php
                                endforeach;
                            ?>
                        </select>
                    </td>
                </tr>
                <?php
                    endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>

<a href="index.php?page=itemtype&amp;action=add" class="btn btn-lg btn-primary">Create Item Type</a>