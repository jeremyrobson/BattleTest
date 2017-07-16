<?php

include_once("../server/DAO/ItemDAO.php");

trait ItemAPI {

    public static function getItemsByUnitId($unit_id) {
        //todo: should this require user ownership of unit?
        $daItem = ItemDAO::singleton();
        return $daItem->getItemsByUnitId($unit_id);
    }

    public static function getItemClasses() {
        $daItem = ItemDAO::singleton();
        return $daItem->getItemClasses();
    }

}