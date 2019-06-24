<?php
namespace H22\Plugins\VisualComposer\Components\PostContent;

use H22\Plugins\VisualComposer\Components\BaseComponentController;

if (!class_exists('\H22\Plugins\VisualComposer\Components\PostContent\PostContent')):
    class PostContent extends \WPBakeryShortCode
    {
        use BaseComponentController;

        public function __construct()
        {
            $settings = array(
                'name' => __('Post Content', 'h22'),
                'base' => 'vc_h22_post_content',
                'icon' => 'vc_icon-vc-gitem-post-excerpt',
                'category' => __('Content', 'js_composer'),
                'params' => array(),
                'html_template' => dirname(__FILE__) . '/PostContent.php',
            );
            $init = $this->initBaseController($settings);
            if ($init) {
                parent::__construct($settings);
            }
        }

        public function prepareData($data)
        {
            $data['content'] = 'Random';

            if (get_queried_object()->post_type !== 'pb-template') {
                $data['content'] = wpautop(get_post_field('post_content', get_queried_object_id()));
                $data['content'] = do_shortcode($data['content']);
            }

            // die;
            return $data;
        }
    }
endif;
