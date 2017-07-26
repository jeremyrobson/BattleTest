<?php

include_once("../server/DAO/BaseDAO.php");
include_once("../server/Objects/Item.php");
include_once("../server/Objects/ItemClass.php");
include_once("../server/Objects/ItemType.php");
include_once("../server/Objects/ItemMaterial.php");
include_once("../server/Objects/ItemQuality.php");

class ItemDAO extends BaseDAO {
    static function singleton() {
        static $instance;
        if ($instance === null) {
            $instance = new self;
        }
        return $instance;
    }

    function getItemByItemId($item_id) {
        $item = null;
        try {
            $params = array(":item_id" => $item_id);
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_item
                WHERE item_id = :item_id
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Item", $args);
            $stmt->execute($params);

            $item = $stmt->fetch();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $item;
    }

    function getItemsByUnitId($user_id, $unit_id) {
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

    function getItemsByPartyId($party_id) {
        $items = array();
        try {
            $params = array(":party_id" => $party_id);
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_item
                WHERE game_item.party_id = :party_id
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

    /*
    function getItemClassByClassId($item_class_id) {
        $item_class = null;
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_item_class
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "ItemClass", $args);
            $stmt->execute();
            $item_class = $stmt->fetch();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $item_class;
    }
    */

    function getItemTypes() {
        $item_types = array();
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_item_type
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "ItemType", $args);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $item_types[$row->item_type_id] = $row;
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $item_types;
    }

    /*
    function getItemTypeByTypeId($item_type_id) {
        $item_type = null;
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_item_type
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "ItemType", $args);
            $stmt->execute();
            $item_type = $stmt->fetch();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $item_type;
    }
    */

    function getItemMaterials() {
        $item_materials = array();
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_item_material
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "ItemMaterial", $args);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $item_materials[$row->item_material_id] = $row;
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $item_materials;
    }

    /*
    function getItemMaterialById($material_id) {
        $material = null;
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_item_type
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "ItemMaterial", $args);
            $stmt->execute();
            $material = $stmt->fetch();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $material;
    }
    */

    function getItemQualities() {
        $item_qualities = array();
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_quality
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "ItemQuality", $args);
            $stmt->execute();

            while ($row = $stmt->fetch()) {
                $item_qualities[$row->item_quality_id] = $row;
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $item_qualities;
    }

    /*
    function getItemQualityById($quality_id) {
        $quality = null;
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_item_type
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "ItemQuality", $args);
            $stmt->execute();
            $quality = $stmt->fetch();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $quality;
    }
    */

    function insertItem($item) {
        $item_id = null;

        try {
            //$params = (array) $item;
            $params = array(
                ":item_id" => null,
                ":item_class_id" => $item->item_class_id,
                ":item_type_id" => $item->item_type_id,
                ":user_id" => $item->user_id,
                ":party_id" => $item->party_id,
                ":material_id" => $item->item_material_id,
                ":quality_id" => $item->item_quality_id,
                ":item_name" => $item->item_name,
                ":_pow" => $item->_pow,
                ":_def" => $item->_def,
                ":_acc" => $item->_acc,
                ":_evd" => $item->_evd,
                ":mod_range" => $item->mod_range,
                ":mod_move" => $item->mod_move,
                ":mod_hp" => $item->mod_hp,
                ":mod_mp" => $item->mod_mp,
                ":mod_str" => $item->mod_str,
                ":mod_agl" => $item->mod_agl,
                ":mod_mag" => $item->mod_mag,
                ":mod_sta" => $item->mod_sta,
                ":price" => $item->price
            );
            $stmt = $this->pdo->prepare("
                INSERT INTO game_item
                VALUES (:item_id, :item_class_id, :item_type_id, :user_id, :party_id, :item_material_id, :item_quality_id, :item_name, 
                :_pow, :_def, :_acc, :_evd, :mod_range, :mod_move, :mod_hp, :mod_mp, :mod_str, :mod_agl, :mod_mag, :mod_sta, :price)
            ");

            $stmt->execute($params);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $this->pdo->lastInsertId();
    }

    function addItemToParty($user_id, $party_id, $item) {
        try {
            $params = array(
                ":user_id" => $user_id,
                ":party_id" => $party_id,
                ":item_id" => $item->item_id
            );
            $stmt = $this->pdo->prepare("
                UPDATE game_item
                SET user_id = :user_id, party_id = :party_id
                WHERE item_id = :item_id
            ");
            $stmt->execute($params);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return true;
    }

    function getItemMaterialsByItemTypeId($item_type_id) {
        $item_materials = array();
        try {
            $params = array(
                ":item_type_id" => $item_type_id
            );
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_item_material
                INNER JOIN game_item_type_material ON game_item_material.item_material_id = game_item_type_material.item_material_id
                INNER JOIN game_item_type ON game_item_type_material.item_type_id = game_item_type.item_type_id
                WHERE game_item_type_material.item_type_id = :item_type_id
            ");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute($params);

            while ($row = $stmt->fetch()) {
                $item_materials[$row["item_material_id"]] = $row;
            }
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $item_materials;
    }

    function insertItemType($item_type) {
        try {
            $params = array(
                ":item_class_id" => $item_type->item_class_id,
                ":item_type_name" => $item_type->item_type_name
            );
            $stmt = $this->pdo->prepare("
                INSERT INTO game_item_type
                VALUES (:item_class_id, :item_type_name, )
            ");
            $stmt->execute($params);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $this->pdo->lastInsertId();
    }

    function updateItemType($item_type) {
        try {
            $params = array(
                ":item_type_id" => $item_type->item_type_id,
                ":item_class_id" => $item_type->item_class_id,
                ":item_type_name" => $item_type->item_type_name
            );
            $stmt = $this->pdo->prepare("
                UPDATE game_item_type
                SET item_class_id = :item_class_id, item_type_name = :item_type_name
                WHERE item_type_id = :item_type_id
            ");
            $stmt->execute($params);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return true;
    }

    function deleteItemTypeMaterial($item_type_id) {
        try {
            $params = array(
                ":item_type_id" => $item_type_id
            );
            $stmt = $this->pdo->prepare("
                DELETE FROM game_item_type_material
                WHERE item_type_id = :item_type_id
            ");
            $stmt->execute($params);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return true;
    }

    function insertItemTypeMaterial($item_type_id, $item_materials) {
        try {
            $params = array(
                ":item_type_id" => $item_type->item_type_id
            );
            $sql = "
                INSERT INTO game_item_type_material
                VALUES
            ";
            foreach ($item_materials as $item_material_id) {
                $sql .= " (null, :item_type_id, $item_material_id)";
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return true;
    }

    function deleteItemTypeJobClass($item_type_id) {
        try {
            $params = array(
                ":item_type_id" => $item_type_id
            );
            $stmt = $this->pdo->prepare("
                DELETE FROM game_item_type_job_class
                WHERE item_type_id = :item_type_id
            ");
            $stmt->execute($params);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return true;
    }

    function updateItemTypeJobClass($item_type, $job_classes) {
        try {
            $params = array(
                ":item_type_id" => $item_type->item_type_id
            );
            $sql = "
                INSERT INTO game_item_type_job_class
                VALUES
            ";
            foreach ($item_job_classes as $job_class_id) {
                $sql .= " (null, :item_type_id, $job_class_id)";
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return true;
    }


};

?>