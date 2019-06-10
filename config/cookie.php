<?php

/**
 * Tell WordPress to save the cookie on the domain
 * @var bool
 */

if (strpos($_SERVER['HTTP_HOST'], 'h22.se') !== false) {
    define('COOKIE_DOMAIN', '.h22.se');
} else {
    // Remove port
    $parts = explode(':', $_SERVER['HTTP_HOST']);
    define('COOKIE_DOMAIN', $parts[0]);
}
