<?php

namespace Mi\Framework;

use Mi\Framework\Views\BladeViewBuilder;
use Mi\Framework\Views\TwigViewBuilder;

class Helpers
{
    static public function dump($val): void
    {
        echo "<pre>";
        var_dump($val);
        echo "</pre>";
    }

    static public function dd($val): void
    {
        self::dump($val);
        die();
    }
    
    static function abort($code = 404) : string {
        // 404
        http_response_code($code);
        // you will need to check if you have a controller with the code name
        return "404 Error";
    }



    static function setLoginErrorMsg() {
        if(isset($_SESSION['loginError']) && $_SESSION['loginError']) {
            $_SESSION['loginError'] = false;
            return "Error failed to login";
        }
    }

    static function view($templateName, array $arguments = null) {
        if($_ENV['TEMPLATE_ENGINE'] == 'twig') {
            $twig = new TwigViewBuilder();
            return $twig->render($templateName, $arguments);
        } else if($_ENV['TEMPLATE_ENGINE'] == 'blade') {
            $blade = new BladeViewBuilder();
            return $blade->render($templateName, $arguments);
        }
    }

    static function getAbsolutePath($relativePath) {
        return rtrim($_ENV['BASE_DIR'], '/') . '/' . ltrim($relativePath, '/');
    }
    
    
}
