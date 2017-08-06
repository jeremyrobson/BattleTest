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

    public static function getRaceById($race_id) {
        $daUnit = UnitDAO::singleton();
        return $daUnit->getRaceById($race_id);
    }

    public static function createUnit($user_id, $party_id, $unit) {
        $validate = new BaseValidate();
        $validate->validatePartyId($user_id, $party_id);
        $validate->validateUnit($unit);

        $daUnit = UnitDAO::singleton();
        return $daUnit->insertUnit($user_id, $party_id, $unit);
    }

    public static function getUnitbyUnitId($user_id, $unit_id) {
        $validate = new BaseValidate();
        $validate->getUnitByUnitId($user_id, $unit_id);
        
        $daUnit = UnitDAO::singleton();
        return $daUnit->getUnitByUnitId($unit_id);
    }

    public static function getBaseStats($user_id, $unit_id) {
        $base = array(
            "pow" => 0,
            "def" => 0
        );

        return $base;
    }

    public static function updateUnitEquipment($user_id, $party_id, $unit_id, $equip) {
        //todo: validate equipment

        $daUnit = UnitDAO::singleton();
        return $daUnit->updateUnitEquipment($user_id, $party_id, $unit_id, $equip);
    }

/*
    public static function validateUnit($user_id, $party_id, $unit) {
        $validate = new BaseValidate();
        $validate->validatePartyId($user_id, $party_id);
        $validate->validateUnit($unit);
    }
*/

}

?>