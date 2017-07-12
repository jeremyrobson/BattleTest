<?php

include_once("../server/DAO/UserDAO.php");

trait UserAPI {

    public static function getUserByUsername($username) {
        $validate = new BaseValidate();
        $validate->getUserByUsername($username);

        $daUser = UserDAO::singleton();
        $user = $daUser->getUserByUsername($username);
        if (empty($user)) {
            throw new Exception("User could not be found.");
        }
        return $user;
    }

    public static function verifyUserPassword($username, $password) {
        $daUser = UserDAO::singleton();
        $user = $daUser->verifyUserPassword($username, $password);
    }

    public static function registerUser($username, $password) {
        $validate = new BaseValidate();
        $validate->registerUser($username, $password);

        $daUser = UserDAO::singleton();
        $daUser->insertUser($username, $password);
    }

}


?>