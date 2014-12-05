<?php

/**
 * Core of this project
 * - deals mostly with URL routing
 */
class Application {
    private $controller = '';
    private $method = '';

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
            $this->params = '';

            // Execute controller method
            $this->controller->{$this->method}($this->params);
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
