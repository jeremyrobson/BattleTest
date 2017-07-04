<?php

include_once("../server/DAO/BaseDAO.php");
include_once("../server/Objects/Party.php");
include_once("../server/DAO/UnitDAO.php");

class PartyDAO extends BaseDAO {

    function getPartiesByUserId($user_id) {
        try {
            $params = array(":user_id" => $user_id);
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_party
                WHERE user_id = :user_id
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Party", $args);
            $stmt->execute($params);
            $parties = array();
            
            while ($stmt->fetch()) {
                $parties[] = $stmt;
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $parties;
    }

    function getPartyByPartyId($party_id) {
        try {
            $params = array(":party_id" => $party_id);
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_party
                WHERE party_id = :party_id
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Party", $args);
            $stmt->execute($params);
            $party = $stmt->fetch();

            $daUnit = new UnitDAO();
            $party->units = $daUser->getUnitsByPartyId($party_id);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $party;
    }

}

?>