<?php

namespace Mi\Framework\Views;

use Jenssegers\Blade\Blade;
use Mi\Framework\Helpers;

class BladeViewBuilder implements ViewBuilder
{
    private $blade;
    private function createViewsDirIfNotExists() {
        if(!is_dir($_ENV['BLADE_TEMPLATES_DIR']) ) {
            mkdir($_ENV['BLADE_TEMPLATES_DIR'], 0777, true);
        }
    } 
    public function __construct() {
        if(! class_exists(\Jenssegers\Blade\Blade::class)) {
            throw new \Exception('Jenssegers\Blade\Blade is not installed');
        }
        // create the views dir if it does not exist
        $this->createViewsDirIfNotExists();
        // before inistantiation make sure twig is installed
        $this->blade = new Blade(
            Helpers::getAbsolutePath($_ENV['BLADE_TEMPLATES_DIR'] ? $_ENV['BLADE_TEMPLATES_DIR'] : 'views/blade'), 
            Helpers::getAbsolutePath($_ENV['BLADE_CACHE_DIR'] ? $_ENV['BLADE_CACHE_DIR'] : 'cache/blade' )
        );
    }
    public function render($templateName, array $arguments = null) {
        return  $this->blade->render($templateName, $arguments);
    }
}
