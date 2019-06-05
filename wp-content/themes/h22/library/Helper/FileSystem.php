<?php

namespace H22\Helper;

class FileSystem
{
    /*
        Wordpress has a plugins_url($asset, $path, $plugin) but no theme_url equivalent to resolve a path
    */
    public static function themeUrl($path = '')
    {
        $url = str_replace(
            wp_normalize_path(untrailingslashit(ABSPATH)),
            site_url(),
            wp_normalize_path($path)
        );
        return esc_url_raw($url);
    }
}
