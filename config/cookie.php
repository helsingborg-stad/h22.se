<?php

/**
 * Tell WordPress to save the cookie on the domain
 * @var bool
 */

if (strpos($_SERVER['HTTP_HOST'], "h22.se") !== false) {
    define('COOKIE_DOMAIN', ".h22.se");
} else {
    define('COOKIE_DOMAIN', $_SERVER['HTTP_HOST']);
}
