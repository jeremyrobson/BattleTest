<?php

include_once("../server/BattleException.php");

include_once("../server/Validate/BaseValidate.php");

include_once("../server/API/UserAPI.php");
include_once("../server/API/PartyAPI.php");
include_once("../server/API/UnitAPI.php");
include_once("../server/API/JobClassAPI.php");
include_once("../server/API/ItemAPI.php");

class BattleAPI {

    use UserAPI;
    use PartyAPI;
    use UnitAPI;
    use JobClassAPI;
    use ItemAPI;
}

?>