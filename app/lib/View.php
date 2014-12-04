<?php

/**
 * View library class containing main methods
 */
class View {

    public function show($name, $layout = 'desktop', $raw = false) {
        // Render respective view
        if ($raw == true) {
            require VIEWS_PATH . $layout . '/' . $name . '.php';
        } else {
            require VIEWS_PATH . $layout . '/' . 'header.php';
            require VIEWS_PATH . $layout . '/' . $name . '.php';
            require VIEWS_PATH . $layout . '/' . 'footer.php';
        }
    }
}
