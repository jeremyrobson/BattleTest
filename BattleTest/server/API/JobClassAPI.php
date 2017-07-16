<?php

include_once("../server/DAO/JobClassDAO.php");

trait JobClassAPI {

    public static function getJobClasses() {
        $daJobClass = JobClassDAO::singleton();
        return $daJobClass->getJobClasses();
    }

    public static function getJobClassById($job_class_id) {
        $daJobClass = JobClassDAO::singleton();
        return $daJobClass->getJobClassById($job_class_id);
    }

    public static function getSkillsByJobClassId($job_class_id) {
        $daJobClass = JobClassDAO::singleton();
        return $daJobClass->getSkillsByJobClassId($job_class_id);
    }

}