<?php

include_once("../server/DAO/PartyDAO.php");
include_once("../server/DAO/UnitDAO.php");

trait UnitValidate {
    
    public function getUnitsByPartyId($user_id, $party_id) {
        $daParty = new PartyDAO();
        $party = $daParty->getPartyByPartyId($party_id);

        if ($party->user_id !== $user_id) {
            throw new BattleException("That party does not belong to you.", $this->error);
        }
    }

    public function getUnitByUnitId($user_id, $unit_id) {
        $daUnit = new UnitDAO();
        $unit = $daUnit->getUnitByUnitId($unit_id);

        if ($unit->user_id !== $user_id) {
            throw new BattleException("That unit does not belong to you.", $this->error);
        }
    }

    public function validateUnit($unit) {
        if (!is_int((int)($unit->race_id))) {
            throw new BattleException("Invalid race ID.", $this->error);
        }

        if (!is_int((int)($unit->party_id))) {
            throw new BattleException("Invalid party ID.", $this->error);
        }

        if (empty($unit->unit_name)) {
            $this->error["unit_name"] = "Unit must have a name.";
        }

        if (!empty($this->error)) {
            throw new BattleException("There are errors.", $this->error);
        }
    }

}

?>