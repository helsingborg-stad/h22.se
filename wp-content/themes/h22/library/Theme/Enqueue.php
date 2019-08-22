<?php

namespace H22\Theme;

use H22\Helper\CacheBust as CacheBust;

class Enqueue
{
    public function __construct()
    {
        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'style'), 30);
        add_action('admin_enqueue_scripts', array($this, 'adminStyle'), 30);
        add_action('wp_enqueue_scripts', array($this, 'script'));
        add_action('admin_enqueue_scripts', array($this, 'adminScript'), 30);
    }

    /**
     * Enqueue styles
     * @return void
     */
    public function style()
    {
        wp_enqueue_style(
            'h22',
            get_stylesheet_directory_uri() .
                '/assets/dist/' .
                CacheBust::name('css/app.css'),
            array(),
            ''
        );
        wp_dequeue_style('js_composer_front');
        wp_dequeue_style('hbg-prime');
        wp_dequeue_style('hbg-prime-bem');
        wp_dequeue_style('municipio');
    }

    public function adminStyle()
    {
        wp_enqueue_style(
            'admin-h22',
            get_stylesheet_directory_uri() .
                '/assets/dist/' .
                CacheBust::name('css/admin.css'),
            array(),
            ''
        );
    }

    /**
     * Enqueue scripts
     * @return void
     */
    public function script()
    {
        wp_register_script(
            'h22-js',
            get_stylesheet_directory_uri() .
                '/assets/dist/' .
                CacheBust::name('js/app.js'),
            array('jquery')
        );
        wp_localize_script('h22-js', 'h22APP', array());
        wp_enqueue_script('h22-js');
        wp_deregister_script('hbg-prime');
        wp_dequeue_script('hbg-prime');
    }

    public function adminScript()
    {
    }
}
