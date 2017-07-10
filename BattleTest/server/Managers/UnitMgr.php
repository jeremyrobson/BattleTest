<?php

include_once("../server/Managers/BaseMgr.php");
include_once("../server/Objects/Unit.php");

class UnitMgr extends BaseMgr {

    function route(&$action) {
        parent::route($action);

        if (!$this->logged) {
            $_SESSION["error_msg"] = "You must be logged in to view this page!";
            $this->redirect(array(
                "page" => "login"
            ));
        }

        $this->template = "../server/Views/unit_list.php";

        switch ($action) {
            case "add":
                $this->add();
                break;
            case "create":
                $this->create();
                break;
            default:
                $this->list();
                break;
        }
        
    }

    function list() {
        $user_id = $_SESSION["user"]->user_id;
        $party_id = $this->input["get"]["party_id"];
        try {
            $this->output["units"] = BattleAPI::getUnitsByPartyId($user_id, $party_id);
        }
        catch (BattleException $e) {
            $_SESSION["error_msg"] = $e->getMessage();
            $this->output["error"] = $e->error;
            $this->redirect(array(
                "page" => "party",
                "action" => "list"
            ));
        }
        catch (Exception $e) {
            $_SESSION["error_msg"] = $e->getMessage();
        }
    }

    function add() {
        $this->template = "../server/Views/unit_add.php";
        $this->output["races"] = UnitAPI::getRaces();
        $this->output["job_classes"] = UnitAPI::getJobClasses();
        $party_id = $this->input["get"]["party_id"];
        $this->output["party_id"] = $party_id;
        $user_id = $_SESSION["user"]->user_id;

        try {
            UnitAPI::validatePartyId($user_id, $party_id);
        }
        catch (BattleException $e) {
            $_SESSION["error_msg"] = $e->getMessage();
            $this->output["error"] = $e->error;
            $this->redirect(array(
                "page" => "party",
                "action" => "view"
            ));
        }
        catch (Exception $e) {
            $_SESSION["error_msg"] = $e->getMessage();
        }
    }

    function create() {
        $user_id = $_SESSION["user"]->user_id;
        $party_id = $this->input["post"]["party_id"];
        try {
            $unit = new Unit($this->input["post"]["unit"]);
            $unit_id = BattleAPI::createUnit($user_id, $party_id, $unit);
            $_SESSION["success_msg"] = "Unit created successfully!";
            $this->redirect(array(
                "page" => "party",
                "action" => "view",
                "party_id" => $party_id
            ));
        }
        catch (BattleException $e) {
            $_SESSION["error_msg"] = $e->getMessage();
            $this->output["error"] = $e->error;
            $this->redirect(array(
                "page" => "party",
                "action" => "view",
                "party_id" => $party_id
            ));
        }
        catch (Exception $e) {
            $_SESSION["error_msg"] = $e->getMessage();
        }


    }


}

?>