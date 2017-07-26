<?php

include_once("../server/Objects/BaseObject.php");

class JobClass extends BaseObject {
    public $job_class_id;
    public $job_class_name;
    public $mod_hp;
    public $mod_mp;
    public $mod_str;
    public $mod_agl;
    public $mod_mag;
    public $mod_sta;
    public $mod_move;
    public $skills;

    function __construct($arr = array()) {
        parent::__construct($arr);

        $this->skills = BattleAPI::getSkillsByJobClassId($this->job_class_id);
    }
}

?>