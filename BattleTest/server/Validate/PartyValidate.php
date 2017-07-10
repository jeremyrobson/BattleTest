<?php

include_once("../server/DAO/PartyDAO.php");

trait PartyValidate {

    public function getPartyByPartyId($user_id, $party_id) {
        $daParty = new PartyDAO();
        $party = $daParty->getPartyByPartyId($party_id);

        if ($party->user_id !== $user_id) {
            throw new BattleException("That party does not belong to you.", $this->error);
        }
    }

}

?>