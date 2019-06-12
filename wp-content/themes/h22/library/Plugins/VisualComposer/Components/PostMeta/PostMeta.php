<?php
namespace H22\Plugins\VisualComposer\Components\PostMeta;

if (!class_exists('\H22\Plugins\VisualComposer\Components\PostMeta\PostMeta')):
    class PostMeta extends \WPBakeryShortCode
    {
        use \H22\Plugins\VisualComposer\Components\BaseComponentController;
        public function __construct()
        {
            $settings = array(
                'name' => __('Post Meta', 'h22'),
                'base' => 'vc_h22_post_meta',
                'icon' => 'vc_icon-vc-gitem-post-excerpt',
                'show_settings_on_create' => false,
                'params' => array(),
                'html_template' => dirname(__FILE__) . '/PostMeta.php',
            );
            $init = $this->initBaseController($settings);
            if ($init) {
                parent::__construct($settings);
            }
        }

        public function prepareData($data)
        {
            $data['attributes']['class'][] = 'c-post-meta';
            $data['post_meta'] = get_the_date();

            return $data;
        }
    }
endif;
