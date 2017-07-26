<?php

include_once("../server/Objects/BaseObject.php");

class ItemType extends BaseObject {
    public $item_type_id;
    public $item_class_id;
    public $item_type_name;
    
    public $item_materials;
    public $job_classes;

    function __construct($arr = array()) {
        parent::__construct($arr);

        $this->item_materials = BattleAPI::getItemMaterialsByItemTypeId($this->item_type_id);
        $this->job_classes = BattleAPI::getJobClassesByItemTypeId($this->item_type_id);
    }
}

?>