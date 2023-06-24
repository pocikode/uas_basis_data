<?php

if (!function_exists('evalBool')) {
    function evalBool($value): bool
    {
        return !strcasecmp($value, 'true');
    }
}

if (!function_exists('redirect')) {
    function redirect($location): void
    {
        header("Location: $location");
        exit();
    }
}

if (!function_exists('session')) {
    function session($key)
    {
        if (isset($_SESSION[$key]) and !empty($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return null;
    }
}

if (!function_exists('session_flash')) {
    function session_flash($key)
    {
        if (isset($_SESSION[$key]) and !empty($_SESSION[$key])) {
            $val = $_SESSION[$key];
            unset($_SESSION[$key]);

            return $val;
        }

        return null;
    }
}

if (!function_exists('is_route')) {
    function is_route($name): bool
    {
        $explodePath = explode('/', $_SERVER['REQUEST_URI']);
        $menuPath = strtok($explodePath[1], '?');

        return $name == $menuPath;
    }
}
