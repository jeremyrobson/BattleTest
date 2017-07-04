<?php

require_once("../server/Managers/LoginMgr.php");
require_once("../server/Managers/RegisterMgr.php");
require_once("../server/Managers/HomeMgr.php");
require_once("../server/Managers/PartyMgr.php");

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

$config = parse_ini_file("../server/config.ini", true);

//todo: change to better page routing method
if (isset($_GET["p"])) {
    $page = $_GET["p"];
}

//404
//todo: logged in user defaults to home, not login
if (!array_key_exists($page, $config["managers"])) {
    $page = "login";
}

$class = new $config["managers"][$page]();

extract($class->output);

require "../server/Views/navbar.php";
require "../server/Views/alert.php";
require $class->template;

?>

</body>

</html>