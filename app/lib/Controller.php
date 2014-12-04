<?php

/**
 * Base-controller class containing main methods
 */
class Controller {

    function __construct() {

        // Initialize view object
        $this->view = new View();
    }

    function loadModel($name) {
        require MODELS_PATH . $name . '.php';
    }
}
