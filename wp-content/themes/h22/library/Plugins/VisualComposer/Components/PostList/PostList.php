<?php
namespace H22\Plugins\VisualComposer\Components\PostList;

use Doctrine\Common\Inflector\Inflector;
use WP_Query;

if (!class_exists('\H22\Plugins\VisualComposer\Components\PostList\PostList')):
    class PostList extends \WPBakeryShortCode
    {
        use \H22\Plugins\VisualComposer\Components\BaseComponentController;

        protected static $postListItemViewsLoaded;

        public function __construct()
        {
            $settings = array(
                'name' => __('PostList', 'h22'),
                'base' => 'vc_h22_postlist',
                'icon' => 'icon-wpb-ui-empty_space',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Heading', 'h22'),
                        'param_name' => 'heading',
                    ),
                    array(
                        'type' => 'dropdown',
                        'param_name' => 'post_type',
                        'heading' => __('Post type', 'h22'),
                        // // Get all post types and convert to options array
                        // 'value' => array_column(
                        //     array_map(
                        //         'get_object_vars',
                        //         get_post_types([
                        //             // 'public' => true
                        //             ], 'objects')
                        //     ),
                        //     'name',
                        //     'label'
                        // ),
                        // We have to add post types manually because custom
                        // post types are registered after this hook is run.
                        'value' => [
                            'News' => 'news',
                            'Projects' => 'projects',
                        ],
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Columns', 'h22'),
                        'param_name' => 'columns',
                        'value' => [
                            '2' => 2,
                            '3' => 3,
                            '4' => 4,
                        ],
                        'std' => 3,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Rows', 'h22'),
                        'param_name' => 'rows',
                        'value' => 4,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Archive button text', 'h22'),
                        'param_name' => 'archive_link_text',
                        'description' => __(
                            'Leave this empty if you don’t want a link to the archive',
                            'h22'
                        ),
                    ),
                ),
                'html_template' => dirname(__FILE__) . '/PostList.php',
            );
            $init = $this->initBaseController($settings);
            if ($init) {
                parent::__construct($settings);
            }
        }

        public function loadPostListItemViews()
        {
            if (static::$postListItemViewsLoaded) {
                return;
            }
            $directory = dirname(__FILE__) . '/Items';
            $components = array();
            foreach (@glob($directory . '/*') as $file) {
                require_once $file;
            }
            static::$postListItemViewsLoaded = true;
        }

        public function getPostListItemClass($post_type)
        {
            $this->loadPostListItemViews();
            if ($post_type) {
                $class =
                    'H22\\Plugins\\VisualComposer\\Components\\PostList\\Items\\' .
                    Inflector::classify($post_type);
                if (class_exists($class)) {
                    return $class;
                }
            }
            return 'H22\\Plugins\\VisualComposer\\Components\\PostList\\Items\\PostListItem';
        }

        public function prepareData($data)
        {
            $post_type = $data['post_type'] = $data['post_type'] ?? 'news';
            $data['attributes']['class'][] = 'c-post-list';
            $data['columns'] = $data['columns'] ?? 3;
            $query = new WP_Query([
                'post_type' => $post_type,
                'posts_per_page' => ($data['columns']) * ($data['rows'] ?? 4),
            ]);
            $class = $this->getPostListItemClass($post_type);
            $data['posts'] = [];
            while ($query->have_posts()) {
                $query->the_post();
                $data['posts'][] = (new $class($post))->render();
                wp_reset_postdata();
            }
            if (!empty($data['archive_link_text'])) {
                $data['archive_link']['text'] = $data['archive_link_text'];
                $data['archive_link']['attributes'][
                    'href'
                ] = get_post_type_archive_link($post_type);
                $data['archive_link']['attributes']['class'][] =
                    'c-button-group__link';
                $data['archive_link']['attributes']['class'][] =
                    'c-button-group__link--default';
            }
            return $data;
        }
    }
endif;
