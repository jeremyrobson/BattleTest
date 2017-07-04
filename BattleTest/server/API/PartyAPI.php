<?php

include_once("../server/DAO/PartyDAO.php");

trait PartyAPI {

    public function getPartiesByUserId($user_id) {
        $daParty = new PartyDAO();
        return $daParty->getPartiesByUserId($user_id);
    }

    public function getPartyByPartyId($party_id) {
        $daParty = new PartyDAO();
        return $daParty->getPartyByPartyId($party_id);
    }

    public function createParty($user, $party_name) {

    }

}

?>