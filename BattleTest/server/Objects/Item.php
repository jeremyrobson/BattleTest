<?php

include_once("../server/Objects/BaseObject.php");

class Item extends BaseObject {
    public $item_id;
    public $item_type_id;
    public $user_id;
    public $material_id;
    public $quality_id;
    public $item_name;
    public $_pow;
    public $_def;
    public $_acc;
    public $_evd;
    public $mod_range;
    public $mod_move;
    public $mod_hp;
    public $mod_mp;
    public $mod_str;
    public $mod_agl;
    public $mod_mag;
    public $mod_sta;
    public $price;
}

?>