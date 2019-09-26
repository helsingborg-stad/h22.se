<?php

namespace H22\Theme;

class Navigation
{
    public function __construct()
    {
        add_filter('wp_nav_menu', array($this, 'appendDropdownClasses'), 10, 1);
    }

    public function appendDropdownClasses($items)
    {
        $re = '/(<li.*?class=".*?menu-item-has-children.*?)("><a.*?)(>.*<ul.?class="sub-menu)(">.*?<\/ul>.*?<\/li>)/ms';

        $str = $items;
        preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

        if (count($matches) === 0) {
            return $items;
        }

        return preg_replace($re, '$1 js-dropdown c-dropdown c-dropdown--menu$2 class="c-dropdown__toggle"$3 unlist c-dropdown__body$4', $str);
    }
}
