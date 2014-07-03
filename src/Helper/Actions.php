<?php
namespace \Smartscore\Helper;

class Actions {

    public static function redirect($url, $status = 302) {
        header("Location: $url", true, $status);
        die();
    }

}
