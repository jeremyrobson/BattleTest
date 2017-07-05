<?php

include_once("../server/BattleException.php");

include_once("../server/API/UserAPI.php");
include_once("../server/API/PartyAPI.php");

class BattleAPI {

    use UserAPI;
    use PartyAPI;
}

?>