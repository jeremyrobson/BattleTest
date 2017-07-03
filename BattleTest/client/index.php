<?php
include_once("../server/API/BattleAPI.php");
session_start();
?>

<!doctype html>
<html>

<head>

<link rel="stylesheet" href="css/bootstrap.min.css" />
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</head>

<body>

<?php 

$action = null;

if (isset($_POST["action"])) {
    $action = $_POST["action"];
}
else if (isset($_GET["action"])) {
    $action = $_GET["action"];
}

$page = null;

if (isset($_GET["p"])) {
    $page = $_GET["p"];
}

switch ($action) {
    case "login":
        $input_username = htmlspecialchars($_POST["username"]);
        $input_password = htmlspecialchars($_POST["password"]);
        try {
            $user = BattleAPI::getUserByUsername($input_username);
            BattleAPI::verifyUserPassword($input_username, $input_password);
            $_SESSION["username"] = $input_username;
            header("Location: index.php?p=home");
            die();
        }
        catch (Exception $e) {
            $error_msg = $e->getMessage();
        }
        break;
    case "logout":
        unset($_SESSION["username"]);
            $_SESSION["success_msg"] = "You have successfully logged out!";
            header("Location: index.php?p=login");
            die();
        break;
    case "register":
        $input_username = htmlspecialchars($_POST["username"]);
        $input_password = htmlspecialchars($_POST["password"]);
        try {
            $user = BattleAPI::registerUser($input_username, $input_password);
            $_SESSION["success_msg"] = "You have successfully registered!";
            header("Location: index.php?p=login");
            die();
        }
        catch (Exception $e) {
            $error_msg = $e->getMessage();
        }
        break;
    default:
        break;
}

require "../server/Views/navbar.php";
require "../server/Views/alert.php";

switch ($page) {
    case "test":
        require "../server/Views/test.php";
        break;
    case "register":
        require "../server/Views/register.php";
        break;
    case "home":
        if (!isset($_SESSION["username"])) {
            header("Location: index.php?p=login");
            die();
        }
        require "../server/Views/home.php";
        break;
    case "login":
    default:
        require "../server/Views/login.php";
        break;
}

?>

</body>

</html>