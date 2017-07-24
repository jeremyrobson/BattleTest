<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

//todo: get from ini and loop to require
require_once("../server/Managers/LoginMgr.php");
require_once("../server/Managers/RegisterMgr.php");
require_once("../server/Managers/HomeMgr.php");
require_once("../server/Managers/PartyMgr.php");
require_once("../server/Managers/UnitMgr.php");
require_once("../server/Managers/JobClassMgr.php");

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
$page = "login";

if (isset($_GET["page"])) {
    $page = $_GET["page"];
}

//404
//todo: logged in user defaults to home, not login
if (!array_key_exists($page, $config["managers"])) {
    if (isset($_SESSION["user"])) {
        $page = "home";
    }
    else {
        $page = "login";
    }
}

$class = new $config["managers"][$page]();

extract($class->output);

require "../server/Views/navbar.php";
require "../server/Views/alert.php";
require $class->template;

?>

</body>

</html>