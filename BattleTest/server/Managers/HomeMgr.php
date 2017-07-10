<?php

include_once("../server/Managers/BaseMgr.php");

class HomeMgr extends BaseMgr {
    
    function route(&$action) {
        parent::route($action);

        if (!$this->logged) {
            $_SESSION["error_msg"] = "You must be logged in to view this page!";
            $this->redirect(array(
                "page" => "login"
            ));
        }

        $this->template = "../server/Views/home.php";

        switch ($action) {
            default:
                break;
        }
    }
}


?>