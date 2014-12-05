<?php

/**
 * Base-view class containing main methods
 */
class View {

    public function show($name, $custom_base_layout = '_static', $raw = false) {
        // Render respective view
        if ($raw == true) {
            require VIEWS_PATH . $name . '.php';
        } else {
            require VIEWS_PATH . $custom_base_layout . '/header.php';
            require VIEWS_PATH . $name . '.php';
            require VIEWS_PATH . $custom_base_layout . '/footer.php';
        }
    }
}
