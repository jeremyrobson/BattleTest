<?php
    //todo: automatically do this
    if (!isset($username)) {
        $username = "";
    }

    $error_username = "";
    if (isset($error["username"])) {
        $error_username = $error["username"];
    }

    $error_password = "";
    if (isset($error["password"])) {
        $error_password = $error["password"];
    }
?>

<h1>Login</h1>
<form action="" method="post">
    <input type="hidden" name="action" value="login" />
    <div class="form-group <?php if ($error_username): ?> has-danger <?php endif; ?>">
        <label class="form-control-label" for="username">Username:</label>
        <input type="text" class="form-control" id="username" name="username" value="<?=$username?>">
        <?php if (isset($error_username)): ?>
        <div class="text-danger"><?=$error_username;?></div>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label class="form-control-label" for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password">
        <?php if (isset($error_password)): ?>
        <div class="text-danger"><?=$error_password;?></div>
        <?php endif; ?>
    </div>
    <div class="g-recaptcha" data-sitekey="<?=$sitekey?>"></div>
    <div class="pull-right">
        <button class="btn btn-lg btn-primary" type="submit">Login</button>
    </div>
    <div class="clearfix"></div>
</form>
<div>
    <a href="index.php?page=register">Register</button>
</div>

<script src='https://www.google.com/recaptcha/api.js'></script>