<?php
namespace H22\Plugins\VisualComposer\Components\ArchiveIndex;

use H22\Plugins\VisualComposer\Components\BaseComponentController;

if (!class_exists('\H22\Plugins\VisualComposer\Components\ArchiveIndex\ArchiveIndex')):
    class ArchiveIndex extends \WPBakeryShortCode
    {
        use BaseComponentController;
        public static $omg = 'lol';


        public function __construct()
        {
            $settings = array(
                'name' => __('Archive Index', 'h22'),
                'base' => 'vc_h22_archive_index',
                'icon' => 'vc_icon-vc-gitem-post-excerpt',
                'category' => __('Content', 'js_composer'),
                'params' => array(),
                'html_template' => dirname(__FILE__) . '/ArchiveIndex.php',
            );
            $init = $this->initBaseController($settings);
            if ($init) {
                parent::__construct($settings);
            }
        }

        public function prepareData($data)
        {
            $data['content'] = 'Archive Index';


            // die;
            return $data;
        }
    }
endif;
