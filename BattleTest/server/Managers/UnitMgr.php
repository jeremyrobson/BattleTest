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
            case "equip":
                $this->equip();
                break;
            case "add":
                $this->add();
                break;
            case "create":
                $this->create();
                break;
            case "view":
                $this->view();
                break;
            case "update":
                $this->update();
                break;
            case "list":
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
        $this->output["races"] = BattleAPI::getRaces();
        $this->output["job_classes"] = BattleAPI::getJobClasses();
        $party_id = $this->input["get"]["party_id"];
        $this->output["party_id"] = $party_id;
        $user_id = $_SESSION["user"]->user_id;

        try {
            BattleAPI::validatePartyId($user_id, $party_id);
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

            //this is essentially the add() action from above
            //todo: figure out better way of replicating add() action
            $this->template = "../server/Views/unit_add.php";
            $this->output["races"] = BattleAPI::getRaces();
            $this->output["job_classes"] = BattleAPI::getJobClasses();
            $party_id = $this->input["get"]["party_id"];
            $this->output["party_id"] = $party_id;
            $user_id = $_SESSION["user"]->user_id;
        }
        catch (Exception $e) {
            $_SESSION["error_msg"] = $e->getMessage();
        }
    }

    function view() {
        $this->template = "../server/Views/unit_view.php";
        $user_id = $_SESSION["user"]->user_id;
        $unit_id = $this->input["get"]["unit_id"];
        
        try {
            $unit = BattleAPI::getUnitByUnitId($user_id, $unit_id);
            $this->output["unit"] = $unit;
            $this->output["race"] = BattleAPI::getRaceById($unit->race_id);
            $this->output["job_class"] = BattleAPI::getJobClassById($unit->job_class_id);
            $this->output["item_classes"] = BattleAPI::getItemClasses();
        }
        catch (BattleException $e) {
            $_SESSION["error_msg"] = $e->getMessage();
            $this->output["error"] = $e->error;
            $this->redirect(array(
                "page" => "party",
                "action" => "view",
                //"party_id" => $this->input party_id
            ));
        }
        catch (Exception $e) {
            $_SESSION["error_msg"] = $e->getMessage();
        }

    }

    function equip() {
        $this->template = "../server/Views/equip.php";
        $user_id = $_SESSION["user"]->user_id;
        $unit_id = $this->input["get"]["unit_id"];

        try {
            $unit = BattleAPI::getUnitByUnitId($user_id, $unit_id);
            $this->output["unit"] = $unit;
            $this->output["items"] = BattleAPI::getItemsByPartyId($user_id, $unit_id);
            $this->output["item_classes"] = BattleAPI::getItemClasses();

            $this->output["base"] = BattleAPI::getBaseStats($user_id, $unit_id);
            $this->output["total"] = BattleAPI::getBaseStats($user_id, $unit_id);
        }
        catch (BattleException $e) {
            $_SESSION["error_msg"] = $e->getMessage();
            $this->output["error"] = $e->error;
            $this->redirect(array(
                "page" => "unit",
                "action" => "view",
                "unit_id" => $unit_id
            ));
        }
        catch (Exception $e) {
            $_SESSION["error_msg"] = $e->getMessage();
        }
    }

    function update() {
        $this->template = "../server/Views/unit_view.php";
        $user_id = $_SESSION["user"]->user_id;
        $unit_id = $this->input["get"]["unit_id"];
        

        try {
            $unit = BattleAPI::getUnitByUnitId($user_id, $unit_id);
            $equip = $this->input["post"]["equip"];
            BattleAPI::updateUnitEquipment($user_id, $unit->party_id, $unit_id, $equip);
        }
        catch (BattleException $e) {
            $_SESSION["error_msg"] = $e->getMessage();
            $this->output["error"] = $e->error;
            $this->redirect(array(
                "page" => "unit",
                "action" => "equip",
                "unit_id" => $unit_id
            ));
        }
        catch (Exception $e) {
            $_SESSION["error_msg"] = $e->getMessage();
        }

        die;

        $_SESSION["success_msg"] = "Unit updated successfully!";
        $this->redirect(array(
            "page" => "unit",
            "action" => "view",
            "unit_id" => $unit_id
        ));
    }

}

?>