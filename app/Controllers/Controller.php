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

        return $twig->render($view . '.twig', $data);
    }
}