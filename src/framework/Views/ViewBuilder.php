<?php

namespace Mi\Framework\Views;

interface ViewBuilder
{
    // public function initEngine();
    public function render($templateName, array $arguments = null);
}
