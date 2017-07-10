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
            
            $daUnit = new UnitDAO();

            while ($row = $stmt->fetch()) {
                $parties[$row->party_id] = $row;
                $parties[$row->party_id]->units = $daUnit->getUnitsByPartyId($row->party_id);
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

            if (!empty($party)) {
                $daUnit = new UnitDAO();
                $party->units = $daUnit->getUnitsByPartyId($party_id);
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $party;
    }

    function insertParty($user_id, $party) {
        try {
            $params = array(
                ":user_id" => $user_id,
                ":party_name" => $party->party_name
            );
            $stmt = $this->pdo->prepare("
                INSERT INTO game_party (user_id, party_name, gold) VALUES
                (:user_id, :party_name, 1000)
            ");
            $stmt->execute($params);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return true;
    }

}

?>