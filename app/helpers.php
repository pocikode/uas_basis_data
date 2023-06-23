<?php

if (!function_exists('evalBool')) {
    function evalBool($value): bool
    {
        return !strcasecmp($value, 'true');
    }
}