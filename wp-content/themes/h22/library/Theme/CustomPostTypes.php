<?php

namespace H22\Theme;

class CustomPostTypes
{
    public function __construct()
    {
        new \H22\Entity\PostType(
            _x('News', 'Post type plural', 'h22'),
            _x('News', 'Post type singular', 'h22'),
            'news',
            array(
                'description' => __('H22 News', 'h22'),
                'menu_icon' => 'dashicons-admin-post',
                'public' => true,
                'publicly_queriable' => true,
                'show_ui' => true,
                'show_in_nav_menus' => true,
                'has_archive' => true,
                // 'rewrite'              =>   array(
                //     'slug'       =>   __('news', 'h22'),
                //     'with_front' =>   false
                // ),
                'hierarchical' => false,
                'exclude_from_search' => false,
                'taxonomies' => array('category', 'post_tag'),
                'supports' => array(
                    'title',
                    'editor',
                    'author',
                    'thumbnail',
                    'excerpt',
                ),
                'show_in_rest' => true,
                'menu_position' => 5,
            )
        );

        new \H22\Entity\PostType(
            _x('Projects', 'Post type plural', 'h22'),
            _x('Project', 'Post type singular', 'h22'),
            'projects',
            array(
                'description' => __('H22 Projects', 'h22'),
                'menu_icon' => 'dashicons-portfolio',
                'public' => true,
                'publicly_queriable' => true,
                'show_ui' => true,
                'show_in_nav_menus' => true,
                'has_archive' => true,
                // 'rewrite'              =>   array(
                //     'slug'       =>   __('projects', 'h22'),
                //     'with_front' =>   false
                // ),
                'hierarchical' => false,
                'exclude_from_search' => false,
                'taxonomies' => array('category', 'post_tag'),
                'supports' => array(
                    'title',
                    'editor',
                    'author',
                    'thumbnail',
                    'excerpt',
                ),
                'show_in_rest' => true,
                'menu_position' => 10,
            )
        );

        new \H22\Entity\PostType(
            _x('Speakers', 'Post type plural', 'h22'),
            _x('Speaker', 'Post type singular', 'h22'),
            'speaker',
            array(
                'description' => __('H22 Projects', 'h22'),
                'menu_icon' => 'dashicons-portfolio',
                'public' => true,
                'publicly_queriable' => true,
                'show_ui' => true,
                'show_in_nav_menus' => true,
                'has_archive' => true,
                // 'rewrite'              =>   array(
                //     'slug'       =>   __('projects', 'h22'),
                //     'with_front' =>   false
                // ),
                'hierarchical' => false,
                'exclude_from_search' => false,
                'taxonomies' => array('category', 'post_tag'),
                'supports' => array(
                    'title',
                    'editor',
                    'author',
                    'thumbnail',
                    'excerpt',
                ),
                'show_in_rest' => true,
                'menu_position' => 10,
            )
        );
    }
}
