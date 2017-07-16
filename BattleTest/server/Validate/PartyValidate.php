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

    public function validateParty($user_id, $party) {
        if (empty($party->party_name)) {
            $this->error["party_name"] = "Party must have a name.";
        }

        if (!empty($this->error)) {
            throw new BattleException("There are errors.", $this->error);
        }
    }

    public function validatePartyId($user_id, $party_id) {
        if (!is_int((int)$party_id)) {
            throw new BattleException("Invalid party ID.", $this->error);
        }

        $daParty = new PartyDAO();
        $parties = $daParty->getPartiesByUserId($user_id);

        if (!array_key_exists($party_id, $parties)) {
            throw new BattleException("That party does not belong to you.", $this->error);
        }
    }

}

?>