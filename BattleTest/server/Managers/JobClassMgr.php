<?php

include_once("../server/Managers/BaseMgr.php");
include_once("../server/Objects/JobClass.php");

class JobClassMgr extends BaseMgr {

    function route(&$action) {
        parent::route($action);

        if (!$this->logged) {
            $_SESSION["error_msg"] = "You must be logged in to view this page!";
            $this->redirect(array(
                "page" => "login"
            ));
        }

        $this->template = "../server/Views/job_class_list.php";

        switch ($action) {
            case "view":
                $this->view();
                break;
            case "list":
            default:
                $this->list();
                break;
        }
        
    }

    function list() {
        try {
            $this->output["job_classes"] = BattleAPI::getJobClasses();
        }
        catch (BattleException $e) {
            $_SESSION["error_msg"] = $e->getMessage();
            $this->output["error"] = $e->error;
            $this->redirect(array(
                "page" => "jobclass",
                "action" => "list"
            ));
        }
        catch (Exception $e) {
            $_SESSION["error_msg"] = $e->getMessage();
        }
    }

    function view() {
        $this->template = "../server/Views/job_class_view.php";
        $job_class_id = $this->input["get"]["job_class_id"];
        try {
            $this->output["job_class"] = BattleAPI::getJobClassById($job_class_id);
        }
        catch (BattleException $e) {
            $_SESSION["error_msg"] = $e->getMessage();
            $this->output["error"] = $e->error;
            $this->redirect(array(
                "page" => "jobclass",
                "action" => "list"
            ));
        }
        catch (Exception $e) {
            $_SESSION["error_msg"] = $e->getMessage();
        }
    }
}