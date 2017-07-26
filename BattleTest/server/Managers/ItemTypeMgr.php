<?php

include_once("../server/Managers/BaseMgr.php");

class ItemTypeMgr extends BaseMgr {

    function route(&$action) {
        parent::route($action);

        if (!$this->logged) {
            $_SESSION["error_msg"] = "You must be logged in to view this page!";
            $this->redirect("login");
        }

        $this->template = "../server/Views/item_type_list.php";

        switch ($action) {
            case "add":
                $this->add();
                break;
            case "create":
                $this->create();
                break;
            case "list":
            default:
                $this->list();
                break;
        }
        
    }

    function list() {
        $this->output["item_classes"] = BattleAPI::getItemClasses();
        $this->output["item_types"] = BattleAPI::getItemTypes();
        $this->output["materials"] = BattleAPI::getItemMaterials();
        $this->output["job_classes"] = BattleAPI::getJobClasses();
    }

    function add() {
        $this->template = "../server/Views/item_type_add.php";
        $this->output["item_classes"] = BattleAPI::getItemClasses();
        $this->output["item_materials"] = BattleAPI::getItemMaterials();
        $this->output["job_classes"] = BattleAPI::getJobClasses();
    }

    function create() {
        $user_id = $_SESSION["user"]->user_id;

        try {
            $item_type = new ItemType($this->input["post"]["item_type"]);
            $item_type_id = BattleAPI::createItemType($user_id, $item_type);
            $_SESSION["success_msg"] = "Item Type created successfully!";
            $this->redirect(array(
                "page" => "itemtype",
                "action" => "view"
            ));
        }
        catch (BattleException $e) {
            $_SESSION["error_msg"] = $e->getMessage();
            $this->output["error"] = $e->error;

            $this->add();
        }
        catch (Exception $e) {
            $_SESSION["error_msg"] = $e->getMessage();
        }
    }

}