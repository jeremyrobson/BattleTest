
<h1>Materials</h1>
<div class="row">
    <div class="col-md-6">
        <table class="table">
            <thead>
                <tr>
                    <th>Item Material Name</th>
                    <th>POW</th>
                    <th>DEF</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($materials as $item_material_id => $material):
                ?>
                <tr>
                    <td>
                        <?=$material->item_material_name?>
                    </td>
                    <td>
                        <?=$material->mod_pow?>
                    </td>
                    <td>
                        <?=$material->mod_def?>
                    </td>
                </tr>
                <?php
                    endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>