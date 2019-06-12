<?php
namespace H22\Plugins\VisualComposer\Components\ShareBar;

use H22\Plugins\VisualComposer\Components\BaseComponentController;

if (!class_exists('\H22\Plugins\VisualComposer\Components\ShareBar\ShareBar')):
    class ShareBar extends \WPBakeryShortCode
    {
        use BaseComponentController;

        public function __construct()
        {
            $settings = array(
                'name' => __('Share bar', 'h22'),
                'base' => 'vc_h22_share_bar',
                'icon' => 'vc_icon-vc-gitem-post-excerpt',
                'category' => __('Content', 'js_composer'),
                'params' => array(),
                'html_template' => dirname(__FILE__) . '/ShareBar.php',
            );
            $init = $this->initBaseController($settings);
            if ($init) {
                parent::__construct($settings);
            }
        }
        public function prepareData($data)
        {
            if (!($post_id = get_the_ID())) {
                global $post;
                $post_id = $post->ID;
            }

            $data['socialShareUrl'] = urlencode(
                get_home_url(null, '?socialShareId=' . $post_id, null)
            );
            return $data;
        }
    }
endif;
