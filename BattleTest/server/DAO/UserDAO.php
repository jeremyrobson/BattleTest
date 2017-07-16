<?php

include_once("../server/DAO/BaseDAO.php");
include_once("../server/Objects/User.php");

class UserDAO extends BaseDAO {

    static function singleton() {
        static $instance;
        if ($instance === null) {
            $instance = new self;
        }
        return $instance;
    }

    function getUserByUsername($username) {

        try {
            $params = array(":username" => $username);
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_user
                WHERE username = :username
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "User", $args);
            $stmt->execute($params);
            $user = $stmt->fetch();
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $user;
    }

    function verifyUserPassword($username, $password) {
        try {
            $params = array(":username" => $username);
            $stmt = $this->pdo->prepare("
                SELECT * FROM game_user
                WHERE username = :username
            ");
            $args = array();
            $stmt->setFetchMode(PDO::FETCH_CLASS, "User", $args);
            $stmt->execute($params);
            $user = $stmt->fetch();
            $hash = $user->password;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }

        if (!password_verify($password, $hash)) {
            throw new Exception("Username or password is not correct.");
        }
        return true;
    }

    function insertUser($username, $password) {
        try {
            $params = array(
                ":username" => $username,
                ":password" => password_hash($password, PASSWORD_DEFAULT)
            );
            $stmt = $this->pdo->prepare("
                INSERT INTO game_user (username, password) VALUES
                (:username, :password)
            ");
            $stmt->execute($params);
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        return true;
    }
}


?>