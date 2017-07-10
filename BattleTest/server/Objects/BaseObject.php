<?php

class BaseObject {
    function __construct($arr = array()) {
        foreach ($arr as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }
}

?>