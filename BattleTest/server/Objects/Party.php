<?php

include_once("../server/Objects/BaseObject.php");
include_once("../server/API/BattleAPI.php");

class Party extends BaseObject {
    public $party_id;
    public $user_id;
    public $gold;
    public $party_name;
    public $units;
    public $items;

    function __construct($arr = array()) {
        parent::__construct($arr);

        $this->items = BattleAPI::getItemsByPartyId($this->user_id, $this->party_id);
    }
}

?>