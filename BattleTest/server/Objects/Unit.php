<?php

include_once("../server/Objects/BaseObject.php");

class Unit extends BaseObject {
    public $unit_id;
    public $user_id;
    public $party_id;
    public $race_id;
    public $job_class_id;
    public $unit_name;
    public $max_hp;
    public $max_mp;
    public $max_str;
    public $max_agl;
    public $max_mag;
    public $max_sta;
    public $max_pow;
    public $max_def;
    public $max_acc;
    public $max_evd;
    public $max_move;
    public $max_range;
    public $equip;

    public function __construct($arr = array()) {
        parent::__construct($arr);
        
        $this->max_hp = 50;
        $this->equip = BattleAPI::getItemsByUnitId($this->user_id, $this->unit_id);
    }
}


?>