<?php

include_once("../server/Managers/BaseMgr.php");
include_once("../server/Objects/Party.php");

class PartyMgr extends BaseMgr {

    function route(&$action) {
        parent::route($action);

        if (!$this->logged) {
            $_SESSION["error_msg"] = "You must be logged in to view this page!";
            $this->redirect("login");
        }

        $this->template = "../server/Views/party_list.php";

        switch ($action) {
            case "add":
                $this->add();
                break;
            case "create":
                $this->create();
                break;
            case "view":
                $this->view();
                break;
            case "create_random_item":
                $this->create_random_item();
                break;
            case "list":
            default:
                $this->list();
                break;
        }
        
    }

    function list() {
        $this->output["parties"] = BattleAPI::getPartiesByUserId($this->user->user_id);
    }

    function add() {
        $this->template = "../server/Views/party_add.php";
    }

    function create() {
        $this->template = "../server/Views/party_add.php";
        $user_id = $_SESSION["user"]->user_id;
        try {
            $party = new Party($this->input["post"]["party"]);
            $party_id = BattleAPI::createParty($user_id, $party);
            $_SESSION["success_msg"] = "Party created successfully!";
            $this->redirect(array(
                "page" => "party",
                "action" => "list"
            ));
        }
        catch (BattleException $e) {
            $_SESSION["error_msg"] = $e->getMessage();
            $this->output["error"] = $e->error;
        }
        catch (Exception $e) {
            $_SESSION["error_msg"] = $e->getMessage();
        }
    }

    function view() {
        $this->template = "../server/Views/party_view.php";
        $user_id = $_SESSION["user"]->user_id;
        $party_id = $this->input["get"]["party_id"];
        try {
            $this->output["party"] = BattleAPI::getPartyByPartyId($user_id, $party_id);
            $this->output["races"] = BattleAPI::getRaces();
            $this->output["job_classes"] = BattleAPI::getJobClasses();
            $this->output["item_classes"] = BattleAPI::getItemClasses();
            $this->output["item_types"] = BattleAPI::getItemTypes();
            $this->output["item_materials"] = BattleAPI::getItemMaterials();
            $this->output["item_qualities"] = BattleAPI::getItemQualities();
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

    function create_random_item() {
        $user_id = $_SESSION["user"]->user_id;
        $party_id = $this->input["get"]["party_id"];

        $new_item = BattleAPI::createRandomItem();
        BattleAPI::addItemToParty($user_id, $party_id, $new_item);

        $this->redirect(array(
            "page" => "party",
            "action" => "view",
            "user_id" => $user_id,
            "party_id" => $party_id
        ));
    }
}

?>