<h1>Create Party</h1>

<form action="" method="post">
    <input type="hidden" name="action" value="create" />
    <div class="form-group">
        <label for="party_name">Party Name:</label>
        <input type="text" class="form-control" id="party_name" name="party[party_name]">
        <?php if (isset($error["party_name"])): ?>
        <div class="text-danger"><?=$error["party_name"]?></div>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-lg btn-primary">Create</button>
    <div class="clearfix"></div>
</form>