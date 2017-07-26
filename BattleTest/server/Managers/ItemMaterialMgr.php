<?php

include_once("../server/Managers/BaseMgr.php");

class ItemMaterialMgr extends BaseMgr {

    function route(&$action) {
        parent::route($action);

        if (!$this->logged) {
            $_SESSION["error_msg"] = "You must be logged in to view this page!";
            $this->redirect("login");
        }

        $this->template = "../server/Views/item_material_list.php";

        switch ($action) {
            case "list":
            default:
                $this->list();
                break;
        }
        
    }

    function list() {
        $this->output["materials"] = BattleAPI::getItemMaterials();
    }

    function add() {
        
    }

}