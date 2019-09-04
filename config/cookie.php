<?php

/**
 * Tell WordPress to save the cookie on the domain
 * @var bool
 */

if (!isset($_SERVER['HTTP_HOST']) || (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], "h22.local") !== false)) {
    define('COOKIE_DOMAIN', ".h22.local");
} elseif (strpos($_SERVER['HTTP_HOST'], ".h22.se") !== false) {
    define('COOKIE_DOMAIN', ".h22.se");
} else {
    define('COOKIE_DOMAIN', $_SERVER['HTTP_HOST']);
}
