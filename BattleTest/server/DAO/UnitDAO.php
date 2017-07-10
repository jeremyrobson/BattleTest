<?php

include_once("../server/DAO/BaseDAO.php");
include_once("../server/Objects/Unit.php");
include_once("../server/Objects/Race.php");
include_once("../server/Objects/JobClass.php");

class UnitDAO extends BaseDAO {
    function getUnitsByPartyId($party_id) {
        try {
            $params = array(":party_id" => $party_id);
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_unit
                WHERE party_id = :party_id
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Unit", $args);
            $stmt->execute($params);
            $units = array();
            while ($row = $stmt->fetch()) {
                $units[$row->unit_id] = $row;
            } 
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $units;
    }

    function insertUnit($user_id, $party_id, $unit) {
        try {
            $params = array(
                ":user_id" => $user_id,
                ":party_id" => $party_id,
                ":race_id" => $unit->race_id,
                ":job_class_id" => $unit->job_class_id,
                ":unit_name" => $unit->unit_name,
                ":max_hp" => $unit->max_hp,
                ":max_mp" => $unit->max_mp,
                ":max_str" => $unit->max_str,
                ":max_agl" => $unit->max_agl,
                ":max_mag" => $unit->max_mag,
                ":max_sta" => $unit->max_sta,
                ":max_pow" => $unit->max_pow,
                ":max_def" => $unit->max_def,
                ":max_acc" => $unit->max_acc,
                ":max_evd" => $unit->max_evd,
                ":max_move" => $unit->max_move,
                ":max_range" => $unit->max_range
            );
            $stmt = $this->pdo->prepare("
                INSERT INTO game_unit (user_id, party_id, race_id, job_class_id, unit_name, max_hp, max_mp, max_str, max_agl, max_mag, max_sta, max_pow, max_def, max_acc, max_evd, max_move, max_range) VALUES
                (:user_id, :party_id, :race_id, :job_class_id, :unit_name, :max_hp, :max_mp, :max_str, :max_agl, :max_mag, :max_sta, :max_pow, :max_def, :max_acc, :max_evd, :max_move, :max_range)
            ");
            $stmt->execute($params);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return true;
    }

    function getRaces() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_race
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Race", $args);
            $stmt->execute();
            $races = array();
            while ($row = $stmt->fetch()) {
                $races[$row->race_id] = $row;
            } 
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $races;
    }

    function getJobClasses() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_job_class
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "JobClass", $args);
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
};

?>