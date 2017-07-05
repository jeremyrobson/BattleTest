<?php

include_once("../server/Managers/BaseMgr.php");

class RegisterMgr extends BaseMgr {

    function route($action) {
        parent::route($action);

        $this->template = "../server/Views/register.php";

        switch ($action) {
            case "register":
                $this->register();
                break;
            default:
                break;
        }
    }

    function register() {
        $input_username = htmlspecialchars($this->input["post"]["username"]);
        $input_password = htmlspecialchars($this->input["post"]["password"]);
        $this->output["username"] = $input_username;
        try {
            $user = BattleAPI::registerUser($input_username, $input_password);
            $_SESSION["success_msg"] = "You have successfully registered!";
            header("Location: index.php?p=login");
            die();
        }
        catch (BattleException $e) {
            $_SESSION["error_msg"] = $e->getMessage();
            $this->output["error"] = $e->error;
        }
        catch (Exception $e) {
            $_SESSION["error_msg"] = $e->getMessage();
        }
    }
}


?>