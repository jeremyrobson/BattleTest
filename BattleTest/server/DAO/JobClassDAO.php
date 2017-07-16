<?php

include_once("../server/DAO/BaseDAO.php");
include_once("../server/Objects/JobClass.php");

class JobClassDAO extends BaseDAO {

    static function singleton() {
        static $instance;
        if ($instance === null) {
            $instance = new self;
        }
        return $instance;
    }

    function getJobClasses() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_job_class
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "JobClass", $args);
            $stmt->execute();
            $job_classes = array();
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
};

?>