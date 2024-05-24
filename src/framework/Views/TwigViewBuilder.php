<?php

namespace Mi\Framework\Views;

use Mi\Framework\Helpers;

class TwigViewBuilder implements ViewBuilder
{
    private $twigEnv;
    public function __construct() {
        // before inistantiation make sure twig is installed (twig is the default so it is a dependency and this check might not
        // be of any use)
        $loader = new \Twig\Loader\FilesystemLoader(Helpers::getAbsolutePath( ($_ENV['TWIG_TEMPLATES_DIR'] ? $_ENV['TWIG_TEMPLATES_DIR'] : 'views/twig') ));

        $this->twigEnv = new \Twig\Environment($loader, [
            'cache' => $_ENV['TWIG_CACHE_DIR'] ? $_ENV['TWIG_CACHE_DIR'] : 'cache',
            'auto_reload' =>$_ENV['TWIG_AUTO_RELOAD'],
            'debug' =>  $_ENV['DEBUG'],
        ]);
    }
    public function render($templateName, array $arguments = null) {
        return  $this->twigEnv->render($templateName, $arguments);
    }
}
