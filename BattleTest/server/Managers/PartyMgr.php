<?php

include_once("../server/Managers/BaseMgr.php");

class PartyMgr extends BaseMgr {
    function route($action) {
        parent::route($action);

        if (!$this->logged) {
            $_SESSION["error_msg"] = "You must be logged in to view this page!";
            header("Location: index.php?p=login");
            die();
        }

        $this->template = "../server/Views/party_view.php";

        switch ($action) {
            case "create":
                $this->create();
                break;
            default:
                $this->view();
                break;
        }
        
    }

    function view() {
        $this->output["parties"] = BattleAPI::getPartiesByUserId($this->user->user_id);
    }

    function create() {
        $this->template = "../server/Views/party_create.php";
        

    }
}

?>