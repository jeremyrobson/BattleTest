<h1>Create Item Type</h1>

<form action="" method="post">
    <input type="hidden" name="action" value="create" />

    <div class="form-group">
        <label for="item_type_name">Item Type Name:</label>
        <input type="text" class="form-control" id="item_type_name" name="item_type[item_type_name]">
    </div>

    <div class="form-group">
        <label for="item_class">Item Class:</label>
        <select class="form-control" id="item_class" name="item_type[item_class_id]">
            <?php
                foreach ($item_classes as $item_class_id => $item_class):
                    $id = $item_class_id;
                    $name = $item_class->item_class_name;
            ?>
                <option value="<?=id?>">
                    <?=$name?>
                </option>
            <?php
                endforeach;
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="item_materials">Item Materials:</label>
        <select id="item_materials" name="item_type[item_materials][]" multiple="multiple" class="form-control">
            <?php
                foreach ($item_materials as $item_material_id => $item_material):
                    $id = $item_material_id;
                    $name = $item_material->item_material_name;
            ?>
                <option value="<?=$id?>"><?=$name?></option>
            <?php
                endforeach;
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="job_classes">Item Job Classes:</label>
        <select id="job_classes" name="item_type[job_classes][]" multiple="multiple" class="form-control">
            <?php
                foreach ($job_classes as $job_class_id => $job_class):
                    $id = $job_class_id;
                    $name = $job_class->job_class_name;
            ?>
                <option value="<?=$id?>"><?=$name?></option>
            <?php
                endforeach;
            ?>
        </select>
    </div>

    <button type="submit" class="btn btn-lg btn-primary">Create</button>
    <div class="clearfix"></div>
</form>