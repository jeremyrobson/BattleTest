<?php

include_once("../server/DAO/UserDAO.php");

trait UserAPI {

    public function getUserByUsername($username) {
        $daUser = new UserDAO();
        $user = $daUser->getUserByUsername($username);
        if (empty($user)) {
            throw new Exception("User could not be found.");
        }
        return $user;
    }

    public function verifyUserPassword($username, $password) {
        $daUser = new UserDAO();
        $user = $daUser->verifyUserPassword($username, $password);
    }

    public function registerUser($username, $password) {
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