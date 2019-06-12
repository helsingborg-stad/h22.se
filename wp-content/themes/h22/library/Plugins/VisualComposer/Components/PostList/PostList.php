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
                        ],
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
            if($post_type) {
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
            $post_type = $data['post_type'] ?? 'news';
            $data['attributes']['class'][] = 'c-post-list';
            $query = new WP_Query([
                'post_type' => $post_type,
            ]);
            $class = $this->getPostListItemClass($post_type);
            $data['posts'] = [];
            while ($query->have_posts()) {
                $query->the_post();
                $data['posts'][] = (new $class($post))->render();
                wp_reset_postdata();
            }
            return $data;
        }
    }
endif;
