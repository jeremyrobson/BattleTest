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

    public function validatePartyId($user_id, $party_id) {
        $daParty = new PartyDAO();
        $party = $daParty->getPartyByPartyId($party_id);

        if (!is_int((int)$party_id) || $party->user_id != $user_id) {
            throw new BattleException("Invalid party ID.", $this->error);
        }
    }

}

?>