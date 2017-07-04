<?php

include_once("../server/DAO/BaseDAO.php");
include_once("../server/Objects/Unit.php");

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
            while ($stmt->fetch()) {
                $units[] = $stmt;
            } 
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $units;
    }

};

?>