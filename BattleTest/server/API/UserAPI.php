<?php

include_once("../server/Validate/UserValidate.php");
include_once("../server/DAO/UserDAO.php");

trait UserAPI {

    public static function getUserByUsername($username) {
        $validate = new UserValidate();
        $validate->getUserByUsername($username);

        $daUser = new UserDAO();
        $user = $daUser->getUserByUsername($username);
        if (empty($user)) {
            throw new Exception("User could not be found.");
        }
        return $user;
    }

    public static function verifyUserPassword($username, $password) {
        $daUser = new UserDAO();
        $user = $daUser->verifyUserPassword($username, $password);
    }

    public static function registerUser($username, $password) {
        $validate = new UserValidate();
        $validate->registerUser($username, $password);

        $daUser = new UserDAO();
        $user = $daUser->getUserByUsername($username);
        if (!empty($user)) {
            throw new Exception("Username already exists!");
        }
        else {
            $daUser->insertUser($username, $password);
        }
    }

}


?>