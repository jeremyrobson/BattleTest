<?php

include_once("../server/API/BattleAPI.php");

class BaseMgr {
    public $input;
    public $output;
    public $template;
    public $logged; //todo: change to array of permissions
    public $user;
    //public $success_msg;
    //public $error_msg;

    public function __construct() {
        $this->input = array();
        $this->output = array();

        $this->input["post"] = $_POST;
        $this->input["get"] = $_GET;

        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $action = isset($_GET["action"]) ? $_GET["action"] : null;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $action = isset($_POST["action"]) ? $_POST["action"] : null;
        }

        $this->route($action);
    }

    public function route($action) {
        if (isset($_SESSION["user"])) {
            $this->logged = true;
            $this->user = $_SESSION["user"];
        }
    }

}

?>