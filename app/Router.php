<?php

namespace app;

use ErickFirmo\Router as BaseRouter;

class Router extends BaseRouter
{
    public function run(): void
    {
        echo parent::run();
    }
}