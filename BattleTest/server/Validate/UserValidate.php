<?php

include_once("../server/DAO/UserDAO.php");

trait UserValidate {
    
    public function getUserByUsername($username) {
        if (strlen(trim($username)) == 0) {
            $this->error["username"] = "The username must be greater than 0 characters.";
        }

        if (!empty($this->error)) {
            throw new BattleException("There are errors.", $this->error);
        }
    }

    public function registerUser($username, $password) {
        if (strlen(trim($username)) == 0) {
            $this->error["username"] = "The username must be greater than 0 characters.";
        }

        if (strlen(trim($password)) == 0) {
            $this->error["password"] = "The password must be greater than 0 characters.";
        }

        $daUser = new UserDAO();
        $user = $daUser->getUserByUsername($username);
        if (!empty($user)) {
            $this->error["username"] = "Username already exists!";
        }

        if (!empty($this->error)) {
            throw new BattleException("There are errors.", $this->error);
        }
    }

}

?>