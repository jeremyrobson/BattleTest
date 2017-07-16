<?php

include_once("../server/DAO/BaseDAO.php");
include_once("../server/Objects/Item.php");
include_once("../server/Objects/ItemClass.php");

class ItemDAO extends BaseDAO {
    static function singleton() {
        static $instance;
        if ($instance === null) {
            $instance = new self;
        }
        return $instance;
    }

    function getItemsByUnitId($unit_id) {
        $items = array();
        try {
            $params = array(":unit_id" => $unit_id);
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_item
                LEFT JOIN game_unit_item ON game_item.item_id = game_unit_item.item_id
                WHERE game_unit_item.unit_id = :unit_id
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Item", $args);
            $stmt->execute($params);

            while ($row = $stmt->fetch()) {
                $items[$row->item_class_id] = $row;
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $items;
    }

    function getItemClasses() {
        $item_classes = array();
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_item_class
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "ItemClass", $args);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $item_classes[$row->item_class_id] = $row;
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $item_classes;
    }
};

?>