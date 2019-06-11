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

        $data['languages'] = pll_the_languages(array(
            'show_names' => 1,
            'hide_current' => 1,
            'dropdown' => 0,
            'raw' => 1,
        ));

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
