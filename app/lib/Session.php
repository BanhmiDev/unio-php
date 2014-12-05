<?php

/**
 * Session class
 */
class Session {
    function __construct() {
        // PHP >= 5.4.0 PHP_SESSION_NONE
        if (session_status() == '') {
            session_start();
        }
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public function destroy() {
        session_destroy();
    }
}
