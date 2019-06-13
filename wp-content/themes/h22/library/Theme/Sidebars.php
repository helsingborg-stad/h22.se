<?php
namespace H22\Theme;

class Sidebars
{
    public function __construct()
    {
        add_action('widgets_init', array($this, 'register'));
    }

    public function register()
    {
        register_sidebar(array(
            'id' => 'footer-area-logos',
            'name' => __('Sidfot logotyper', 'municipio'),
            'description' => __(
                'Visa upp logotyper i fullbredd nedanför den vanliga sidfoten',
                'municipio'
            ),
            'before_widget' => '<div class="c-footer__logo"><div class="%2$s">',
            'after_widget' => '</div></div>',
            'before_title' => '<h2 class="footer-title">',
            'after_title' => '</h2>',
        ));
    }
}
