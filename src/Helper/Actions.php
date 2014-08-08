<?php
namespace SmartscoreFramework\Helper;

class Actions {

    # Redirects to $target page
    #
    # @param string Url to redirect to.
    public static function redirect($target, $status = 302) {
        header("Location: $target", true, $status);
        die();
    }

}
