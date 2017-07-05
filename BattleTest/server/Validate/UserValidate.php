<?php

class UserValidate {
    
    public $error;
    
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

        if (!empty($this->error)) {
            throw new BattleException("There are errors.", $this->error);
        }
    }

}

?>