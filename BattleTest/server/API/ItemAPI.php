<?php

include_once("../server/DAO/ItemDAO.php");

trait ItemAPI {

    public static function getItemByItemId($user_id, $item_id) {
        $daItem = ItemDAO::singleton();
        return $daItem->getItemByItemId($item_id);
    }

    public static function getItemsByUnitId($user_id, $unit_id) {
        $daItem = ItemDAO::singleton();
        return $daItem->getItemsByUnitId($unit_id);
    }

    public static function getItemsByPartyId($user_id, $party_id) {
        $daItem = ItemDAO::singleton();
        return $daItem->getItemsByPartyId($party_id);
    }

    public static function getItemClasses() {
        $daItem = ItemDAO::singleton();
        return $daItem->getItemClasses();
    }

    public static function getItemClassByClassId($item_class_id) {
        $daItem = ItemDAO::singleton();
        return $daItem->getItemClassByClassId($item_class_id);
    }

    public static function getItemTypes() {
        $daItem = ItemDAO::singleton();
        return $daItem->getItemTypes();
    }

    public static function getItemTypeByTypeId($item_type_id) {
        $daItem = ItemDAO::singleton();
        return $daItem->getItemTypeByTypeId($item_type_id);
    }

    public static function getItemMaterials() {
        $daItem = ItemDAO::singleton();
        return $daItem->getItemMaterials();
    }

    public static function getItemMaterialById($material_id) {
        $daItem = ItemDAO::singleton();
        return $daItem->getItemMaterialById($material_id);
    }

    public static function getItemQualities() {
        $daItem = ItemDAO::singleton();
        return $daItem->getItemQualities();
    }

    public static function getItemQualityById($quality_id) {
        $daItem = ItemDAO::singleton();
        return $daItem->getItemQualityById($quality_id);
    }

    public static function createRandomItem() {
        $item_types = BattleAPI::getItemTypes();
        $item_materials = BattleAPI::getItemMaterials();
        $item_qualities = BattleAPI::getItemQualities();
        $item_type_id = 1;
        $item_material_id = 1;
        $item_quality_id = 1;
        $item_name = $item_materials[$item_material_id]->item_material_name . " " . $item_types[$item_type_id]->item_type_name;
        $params = array(
            "item_class_id" => 1,
            "item_type_id" => $item_type_id,
            "material_id" => $item_material_id,
            "quality_id" => $item_quality_id,
            "item_name" => $item_name,
            "new_item->_pow" => 3
        );
        $new_item = new Item($params);

        $daItem = ItemDAO::singleton();
        $item_id = $daItem->insertItem($new_item);

        return $daItem->getItemByItemId($item_id);
    }

    public static function addItemToParty($user_id, $party_id, $item) {
        $daItem = ItemDAO::singleton();
        return $daItem->addItemToParty($user_id, $party_id, $item);
    }

    public static function getItemMaterialsByItemTypeId($item_type_id) {
        $daItem = ItemDAO::singleton();
        return $daItem->getItemMaterialsByItemTypeId($item_type_id);
    }

    public static function createItemType($usr_id, $item_type) {
        //todo: validation

        $daItem = ItemDAO::singleton();
        $item_type_id = $daItem->insertItemType($item_type);
        BattleAPI::updateItemTypeMaterial($item_type_id, $item_type->item_materials);
        BattleAPI::updateItemTypeJobClass($item_type_id, $item_type->item_job_classes);
        return $item_type_id;
    }

    function deleteItemTypeMaterial($item_type_id) {
        $daItem = ItemDAO::singleton();
        return $daItem->deleteItemTypeMaterial($item_type_id);
    }

    function updateItemTypeMaterial($item_type_id, $item_materials) {
        BattleAPI::deleteItemTypeMaterial($item_type_id, $item_materials);

        $daItem = ItemDAO::singleton();
        return $daItem->updateItemTypeMaterial($item_type_id, $item_materials);
    }

    function deleteItemTypeJobClass($item_type_id) {
        $daItem = ItemDAO::singleton();
        return $daItem->deleteItemTypeJobClass($item_type_id);
    }

    function updateItemTypeJobClass($item_type_id, $job_classes) {
        BattleAPI::deleteItemTypeJobClass($item_type_id, $job_classes);

        $daItem = ItemDAO::singleton();
        return $daItem->updateItemTypeJobClass($item_type_id, $job_classes);
    }
}