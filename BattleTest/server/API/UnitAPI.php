<?php

include_once("../server/DAO/UnitDAO.php");

trait UnitAPI {

    public static function getUnitsByPartyId($user_id, $party_id) {
        $validate = new BaseValidate();
        $validate->getUnitsByPartyId($user_id, $party_id);

        $daUnit = new UnitDAO();
        return $daUnit->getUnitsByPartyId($party_id);
    }

    public static function getRaces() {
        $daUnit = new UnitDAO();
        return $daUnit->getRaces();
    }

    public static function getJobClasses() {
        $daUnit = new UnitDAO();
        return $daUnit->getJobClasses();
    }

    public static function createUnit($user_id, $party_id, $unit) {
        $validate = new BaseValidate();
        $validate->validatePartyId($user_id, $party_id);

        $daUnit = new UnitDAO();
        return $daUnit->insertUnit($user_id, $party_id, $unit);
    }

    public static function validatePartyId($user_id, $party_id) {
        $validate = new BaseValidate();
        $validate->validatePartyId($user_id, $party_id);
    }

    /*
    public static function getPartyByPartyId($party_id) {
        $daParty = new PartyDAO();
        return $daParty->getPartyByPartyId($party_id);
    }

    public static function createParty($user_id, $party_name) {
        $daParty = new PartyDAO();
        return $daParty->insertParty($user_id, $party_name);
    }
    */

}

?>