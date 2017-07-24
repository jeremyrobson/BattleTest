<?php

include_once("../server/Managers/BaseMgr.php");

class LoginMgr extends BaseMgr {
    
    function route(&$action) {
        parent::route($action);

        $this->template = "../server/Views/login.php";

        switch ($action) {
            case "login":
                $this->login();
                break;
            case "logout":
                $this->logout();
                break;
            default:
                $this->list();
                break;
        }
    }

    function list() {
        global $config;
        $this->output["sitekey"] = $config["recaptcha"]["sitekey"];
    }

    function login() {
        //recaptcha validation/verification
        global $config;
        $this->output["sitekey"] = $config["recaptcha"]["sitekey"];
        $g_recaptcha_response = htmlspecialchars($this->input["post"]["g-recaptcha-response"]);
        $url = $config["recaptcha"]["url"];
        $data = array(
            'secret' => $config["recaptcha"]["secret"],
            'response' => $g_recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        );
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        try {
            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            if ($response === false) {
                throw new Exception("No response from Google...");
            }
            $response = json_decode($response, true);
            if (empty($response["success"])) {
                throw new BattleException("reCAPTCHA Errors: <br>" . implode("<br>", $response["error-codes"]));
            }
            
        }
        catch (BattleException $e) {
            $_SESSION["error_msg"] = $e->getMessage();
            $this->output["error"] = $e->error;
            return;
        }
        catch (Exception $e) {
            $_SESSION["error_msg"] = $e->getMessage();
            $this->output["error"] = $e->error;
            return;
        }

        //user validation/verification
        $input_username = htmlspecialchars($this->input["post"]["username"]);
        $input_password = htmlspecialchars($this->input["post"]["password"]);
        $this->output["username"] = $input_username;
        try {
            $user = BattleAPI::getUserByUsername($input_username);
            BattleAPI::verifyUserPassword($input_username, $input_password);
            $_SESSION["user"] = $user;
            $this->redirect(array(
                "page" => "home"
            ));
        }
        catch (BattleException $e) {
            $_SESSION["error_msg"] = $e->getMessage();
            $this->output["error"] = $e->error;
        }
        catch (Exception $e) {
            $_SESSION["error_msg"] = $e->getMessage();
        }
    }

    function logout() {
        unset($_SESSION["user"]);
        $_SESSION["success_msg"] = "You have successfully logged out!";
        $this->redirect(array(
            "page" => "login"
        ));
    }
}


?>















