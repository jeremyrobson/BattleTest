<?php

include_once("../server/DAO/PartyDAO.php");

trait PartyAPI {

    public static function getPartiesByUserId($user_id) {
        $daParty = PartyDAO::singleton();
        return $daParty->getPartiesByUserId($user_id);
    }

    public static function getPartyByPartyId($user_id, $party_id) {
        $validate = new BaseValidate();
        $validate->getPartyByPartyId($user_id, $party_id);

        $daParty = PartyDAO::singleton();
        return $daParty->getPartyByPartyId($party_id);
    }

    public static function createParty($user_id, $party) {
        $validate = new BaseValidate();
        $validate->validateParty($user_id, $party);

        $daParty = PartyDAO::singleton();
        return $daParty->insertParty($user_id, $party);
    }

    public static function validatePartyId($user_id, $party_id) {
        $validate = new BaseValidate();
        $validate->validatePartyId($user_id, $party_id);
    }

}

?>