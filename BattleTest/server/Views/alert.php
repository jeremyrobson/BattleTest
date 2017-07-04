<?php
    $success_msg = isset($_SESSION["success_msg"]) ? $_SESSION["success_msg"] : null;
    $error_msg = isset($_SESSION["error_msg"]) ? $_SESSION["error_msg"] : null;
    unset($_SESSION["success_msg"]);
    unset($_SESSION["error_msg"]);
?>

<?php
    if (isset($error_msg)):
?>
<div class="alert alert-danger">
    <strong>Error</strong> <?=$error_msg?>
</div>
<?php
    endif;
?>

<?php
    if (isset($success_msg)):
?>
<div class="alert alert-success">
    <strong>Success</strong> <?=$success_msg?>
</div>
<?php
    endif;
?>
