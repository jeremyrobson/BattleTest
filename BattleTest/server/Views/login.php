<?php
    if (!isset($username)) {
        $username = "";
    }
?>

<h1>Login</h1>
<form action="" method="post">
    <input type="hidden" name="action" value="login" />
    <div class="form-group has-danger">
        <label class="form-control-label" for="username">Username:</label>
        <input type="text" class="form-control" id="username" name="username" value="<?=$username?>">
    </div>
    <div class="form-group">
        <label class="form-control-label" for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="pull-right">
        <button class="btn btn-lg btn-primary" type="submit">Login</button>
    </div>
    <div class="clearfix"></div>
</form>
<div>
    <a href="index.php?p=register">Register</button>
</div>