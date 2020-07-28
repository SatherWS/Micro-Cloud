<?php

class AuthenticationError {
    private $err = "<div class='error-msg'>";

    function login_error() {
        $this->err .= "<h4>Error: incorrect credentials or user does not exist.</h4>";
        $this->err .= "</div>";
        return $this->err;
    }

    function bad_pswd($pswd) {
        $this->err .= "<h4>Error: Password is too short or has incorrect formating.</h4>";
        $this->err .= "</div>";
        return $this->err;
    }

}

?>
