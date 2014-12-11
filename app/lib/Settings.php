<?php

class Settings {

    protected static $settings;

    public static function init() {
        $db = new Database();
        $_settings = array();

        // Read settings from database
        $db_settings = $db->query('SELECT name, settings FROM unio_settings');
        foreach ($db_settings as $db_setting) {
            if (!isset($_settings)) $_settings = array($db_setting['name'] => $db_setting['settings']);
            else $_settings[$db_setting['name']] = $db_setting['settings'];
        }

        self::$settings = $_settings;
    }

    public static function set($key, $value) {
        $db->bind('value', $value);
        $db->bind('key', $key);
        $db->query('UPDATE unio_settings SET settings = :value WHERE name = :key');
    }
    
    public static function get($key) {
        if (isset(self::$settings[$key])) {
            return self::$settings[$key];
        }
    }
}
