<?php

/**
 * Core of this project
 * - deals mostly with URL routing
 */
class Application {
    
    protected $controller = BASE_CONTROLLER;
    protected $method = BASE_METHOD;

    /**
     * Routing
     */
    function __construct() {
        $url = $this->parseUrl();

        // Check if controller exists
        if (file_exists('app/controllers/' . $url[0] . '.php')) {

            $this->controller = $url[0];
            // Unset for later method parameters
            unset($url[0]);

            // Call controller
            require 'app/controllers/' . $this->controller . '.php';
            $this->controller = new $this->controller();

            // Second parameter seen as method name
            if (isset($url[1])) {
                if (method_exists($this->controller, $url[1])) {
                    $this->method = $url[1];
                    // Unset for later method parameters
                    unset($url[1]);
                }
            }

            // Leftover from URL-array seen as method parameters
            $this->params = $url;

            // Execute the controller function
            call_user_func_array([$this->controller, $this->method], $this->params);

        } else {
            require 'app/controllers/' . $this->controller . '.php';
            $this->controller = new $this->controller();

            // Use the first parameter as method (which should be found in the base controller)
            if (isset($url[0])) {
                if (method_exists($this->controller, $url[0])) {
                    $this->method = $url[0];

                    call_user_func_array([$this->controller, $this->method], []);
                } else {
                    // If no method is found, redirect with error method
                    $this->method = 'error';

                    call_user_func_array([$this->controller, $this->method], []);
                }
            }
        }
    }

    /**
     * Split given URL
     */
    public function parseUrl() {
        if (isset($_GET['url'])) {
            // Trim, sanitize and split URL
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
