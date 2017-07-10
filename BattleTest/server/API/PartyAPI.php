<?php

include_once("../server/DAO/PartyDAO.php");

trait PartyAPI {

    public static function getPartiesByUserId($user_id) {
        $daParty = new PartyDAO();
        return $daParty->getPartiesByUserId($user_id);
    }

    public static function getPartyByPartyId($user_id, $party_id) {
        $validate = new BaseValidate();
        $validate->getPartyByPartyId($user_id, $party_id);

        $daParty = new PartyDAO();
        return $daParty->getPartyByPartyId($party_id);
    }

    public static function createParty($user_id, $party_name) {
        $daParty = new PartyDAO();
        return $daParty->insertParty($user_id, $party_name);
    }

}

?>