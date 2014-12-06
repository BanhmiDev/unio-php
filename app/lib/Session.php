<?php

/**
 * Session class
 * Example static call: Session:init();
 */
class Session {
    
    function __construct() {

    }

    public static function init() {
        // PHP >= 5.4.0 
        // session_status() == PHP_SESSION_NONE
        if (session_id() == '') {
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public static function id() {
        return session_id();
    }

    public static function destroy() {
        session_destroy();
    }
}
