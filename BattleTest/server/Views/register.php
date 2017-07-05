<?php
    if (!isset($input_username)) {
        $input_username = "";
    }
?>

<h1>Register</h1>
<form action="" method="post">
    <input type="hidden" name="action" value="register" />
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" name="username" value="<?=$input_username?>">
        <?php if (isset($error["username"])): ?>
        <div class="text-danger"><?=$error["username"]?></div>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password">
        <?php if (isset($error["password"])): ?>
        <div class="text-danger"><?=$error["password"]?></div>
        <?php endif; ?>
    </div>
    <button class="btn btn-lg btn-primary" type="submit">Register</button>
</form>
