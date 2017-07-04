<?php

include_once("../server/Managers/BaseMgr.php");

class LoginMgr extends BaseMgr {
    function route($action) {
        parent::route($action);

        $this->template = "../server/Views/login.php";

        switch ($action) {
            case "login":
                $this->login();
                break;
            case "logout":
                $this->logout();
                break;
            default:
                break;
        }
    }

    function login() {
        $input_username = htmlspecialchars($this->input["post"]["username"]);
        $input_password = htmlspecialchars($this->input["post"]["password"]);
        $this->output["username"] = $input_username;
        try {
            $user = BattleAPI::getUserByUsername($input_username);
            BattleAPI::verifyUserPassword($input_username, $input_password);
            $_SESSION["user"] = $user;
            header("Location: index.php?p=home");
            die();
        }
        catch (Exception $e) {
            $_SESSION["error_msg"] = $e->getMessage();
        }
    }

    function logout() {
        unset($_SESSION["user"]);
        $_SESSION["success_msg"] = "You have successfully logged out!";
        header("Location: index.php?p=login");
        die();
    }
}


?>















