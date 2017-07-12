<?php

include_once("../server/DAO/UnitDAO.php");

trait UnitAPI {

    public static function getUnitsByPartyId($user_id, $party_id) {
        $validate = new BaseValidate();
        $validate->getUnitsByPartyId($user_id, $party_id);

        $daUnit = UnitDAO::singleton();
        return $daUnit->getUnitsByPartyId($party_id);
    }

    public static function getRaces() {
        $daUnit = UnitDAO::singleton();
        return $daUnit->getRaces();
    }

    public static function getJobClasses() {
        $daUnit = UnitDAO::singleton();
        return $daUnit->getJobClasses();
    }

    public static function createUnit($user_id, $party_id, $unit) {
        $validate = new BaseValidate();
        $validate->validatePartyId($user_id, $party_id);

        $daUnit = UnitDAO::singleton();
        return $daUnit->insertUnit($user_id, $party_id, $unit);
    }

    public static function validatePartyId($user_id, $party_id) {
        $validate = new BaseValidate();
        $validate->validatePartyId($user_id, $party_id);
    }

}

?>