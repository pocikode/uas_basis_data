<?php

namespace App\Controllers;

use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    protected function view(string $view, array $data = []): string
    {
        $loader = new FilesystemLoader(dirname(__DIR__) . '/Views');
        $view_cache = evalBool($_ENV['VIEW_CACHE']) ? dirname(__DIR__) . '/Views/cache' : false;

        $twig = new \Twig\Environment($loader, ['cache' => $view_cache]);

        $twig->addFunction(new \Twig\TwigFunction('session', function ($key) {
            return session($key);
        }));

        $twig->addFunction(new \Twig\TwigFunction('session_flash', function ($key) {
            return session_flash($key);
        }));

        $twig->addFunction(new \Twig\TwigFunction('is_route', function ($name) {
            return is_route($name);
        }));

        return $twig->render($view . '.twig', $data);
    }
}