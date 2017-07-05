<?php

class BattleException extends Exception {
    public $error;

    public function __construct($message, $error = array(), $code = 0, Exception $previous = null) {
        $this->error = $error;

        parent::__construct($message, $code, $previous);
    }

}


?>