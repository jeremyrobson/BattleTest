<h1>Create Unit</h1>

<form action="" method="post">
    <input type="hidden" name="action" value="create" />
    <input type="hidden" name="party_id" value="<?=$party_id?>" />

    <div class="row">
        <div class="col-md-2 offset-md-2">
            <div class="form-group">
                <label for="unit_name">Unit Name:</label>
                <input type="text" class="form-control" id="unit_name" name="unit[unit_name]">
                <?php if (isset($error["unit_name"])): ?>
                <div class="text-danger"><?=$error["unit_name"]?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="unit_race">Unit Race:</label>
                <select class="form-control" id="unit_race" name="unit[race_id]">
                    <?php foreach($races as $race_id => $race): ?>
                        <option value="<?=$race_id?>"><?=$race->race_name?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <ul class="list-group" id="race_stat_list">
            </ul>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="unit_job_class">Unit Job Class:</label>
                <select class="form-control" id="unit_job_class" name="unit[job_class_id]">
                    <?php foreach($job_classes as $job_class_id => $job_class): ?>
                        <option value="<?=$job_class_id?>"><?=$job_class->job_class_name?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <ul class="list-group" id="job_class_stat_list">
            </ul>
        </div>
    </div>

    <button type="submit" class="btn btn-lg btn-primary">Create</button>
    <div class="clearfix"></div>
</form>

<script>

var races = <?=json_encode($races);?>;
var job_classes = <?=json_encode($job_classes);?>;

function update_race_stat_list(race_id) {
    $("#race_stat_list").empty();
    for (var key in races[race_id]) {
        var html = "<strong>" + key + "</strong>" + races[race_id][key];
        var item = $("<li></li>").addClass("list-group-item justify-content-between").html(html);
        $("#race_stat_list").append(item);
    }
}

function update_job_class_stat_list(job_class_id) {
    $("#job_class_stat_list").empty();
    for (var key in job_classes[job_class_id]) {
        var html = "<strong>" + key + "</strong>" + job_classes[job_class_id][key];
        var item = $("<li></li>").addClass("list-group-item justify-content-between").html(html);
        $("#job_class_stat_list").append(item);
    }
}

$(document).ready(function() {
    $("#unit_race").change(function() {
        update_race_stat_list($(this).val());
    });

    $("#unit_job_class").change(function() {
        update_job_class_stat_list($(this).val());
    });
    update_race_stat_list(1);
    update_job_class_stat_list(1);
});

</script>