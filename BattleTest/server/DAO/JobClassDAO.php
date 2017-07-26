<?php

include_once("../server/DAO/BaseDAO.php");
include_once("../server/Objects/JobClass.php");
include_once("../server/Objects/Skill.php");

class JobClassDAO extends BaseDAO {

    static function singleton() {
        static $instance;
        if ($instance === null) {
            $instance = new self;
        }
        return $instance;
    }

    function getJobClasses() {
        $job_classes = array();
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_job_class
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "JobClass", $args);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
                $job_classes[$row->job_class_id] = $row;
            } 
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $job_classes;
    }

    function getJobClassById($job_class_id) {
        $job_class = null;
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_job_class
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "JobClass", $args);
            $stmt->execute();
            $job_class = $stmt->fetch();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $job_class;
    }

    function getSkillsByJobClassId($job_class_id) {
        $skills = array();
        try {
            $params = array(":job_class_id" => $job_class_id);
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_skill
                WHERE job_class_id = :job_class_id
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Skill", $args);
            $stmt->execute($params);

            while ($row = $stmt->fetch()) {
                $skills[$row->skill_id] = $row;
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $skills;
    }

    function getJobClassesByItemTypeId($item_type_id) {
        $job_classes = array();
        try {
            $params = array(
                ":item_type_id" => $item_type_id
            );
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_job_class
                INNER JOIN game_item_type_job_class ON game_job_class.job_class_id = game_item_type_job_class.job_class_id
                INNER JOIN game_item_type ON game_item_type_job_class.item_type_id = game_item_type.item_type_id
                WHERE game_item_type.item_type_id = :item_type_id
            ");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute($params);

            while ($row = $stmt->fetch()) {
                $job_classes[$row["job_class_id"]] = $row;
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $job_classes;
    }
};

?>