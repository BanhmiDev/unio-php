<?php

/**
 * Index Controller
 */
class Index extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->show('default/index');
    }

    public function about() {
        $this->view->show('default/about');
    }
}