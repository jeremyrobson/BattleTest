<?php

include_once("../server/Validate/UserValidate.php");
include_once("../server/Validate/PartyValidate.php");
include_once("../server/Validate/UnitValidate.php");

class BaseValidate {
    
    public $error;
    
    use UserValidate;
    use PartyValidate;
    use UnitValidate;

}

?>