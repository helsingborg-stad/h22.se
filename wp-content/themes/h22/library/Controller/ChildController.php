<?php

namespace H22\Controller;

class ChildController
{
    public function __construct()
    {
        add_filter('Municipio/viewData', array($this, 'data'), 10, 1);
    }

    public function data($data)
    {
        // $data['mainMenu'] = $this->getWordpressMenuItemsBySlug('main-menu');
        $classes = array('nav');

        if (!empty(get_field('nav_primary_align', 'option'))) {
            $classes[] = 'nav-' . get_field('nav_primary_align', 'option');
        }

        $args = array(
            'echo' => false,
            'depth' => 2,
            'theme_location' => 'main-menu',
            'container' => false,
            'container_class' => 'menu-{menu-slug}-container',
            'container_id' => '',
            'menu_id' => 'main-menu',
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'fallback_cb' => '__return_false'
        );

        $args['menu_class'] = implode(' ', apply_filters('Municipio/main_menu_classes', $classes)) . ' ' . apply_filters('Municipio/desktop_menu_breakpoint', 'hidden-xs hidden-sm');
        $data['navigation']['mainMenu'] = wp_nav_menu($args);

        $langSwicherSettings = get_field('polylang_language_switcher_settings', 'options');
        if (
            function_exists('pll_the_languages') && $langSwicherSettings !== 'disabled' && $langSwicherSettings !== 'logged-in'
            || function_exists('pll_the_languages') && $langSwicherSettings === 'logged-in' && is_user_logged_in()
        ) {
            $data['languages'] = pll_the_languages(array(
                'show_names' => 1,
                'hide_current' => 1,
                'dropdown' => 0,
                'raw' => 1,
            ));
        }

        return $data;
    }

    /**
     * Returns array of Wordpress menu items
     * @param string Slug of a registred menu
     * @return array
     */
    public function getWordpressMenuItemsBySlug($slug)
    {
        if (
            empty(get_nav_menu_locations()) ||
            !isset(get_nav_menu_locations()[$slug])
        ) {
            return array();
        }

        $menu = new \Municipio\Helper\Menu(get_nav_menu_locations()[$slug]);

        return $menu->wpMenu;
    }
}
