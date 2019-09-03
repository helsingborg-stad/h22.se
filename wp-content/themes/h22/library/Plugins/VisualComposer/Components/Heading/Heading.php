<?php

namespace H22\Plugins\VisualComposer\Components\Heading;

use H22\Plugins\VisualComposer\Components\BaseComponentController;

if (!class_exists('\H22\Plugins\VisualComposer\Components\Heading\Heading')) :
    class Heading extends \WPBakeryShortCode
    {
        use BaseComponentController;

        public function __construct()
        {
            $settings = array(
                'name' => __('Heading', 'h22'),
                'base' => 'vc_h22_heading',
                'icon' => 'vc_icon-vc-gitem-post-excerpt',
                'category' => __('Content', 'js_composer'),
                'params' => [
                    [
                        'param_name' => 'h_src',
                        'type' => 'dropdown',
                        'heading' => __('Heading content source', 'h22'),
                        'value' => array(
                            __('Custom', 'h22') => '',
                            __('Dynamic', 'h22') => 'dynamic',
                        ),
                        'group' => '',
                        'weight' => 10
                    ],
                    [
                        'param_name' => 'h_content',
                        'type' => 'textfield',
                        'heading' => __('Heading content', 'h22'),
                        'value' => '',
                        'dependency' => array(
                            'element' => 'h_src',
                            'value' => array(''),
                        ),
                        'group' => '',
                        'weight' => 10,
                        'holder' => 'div',
                    ],
                    [
                        'param_name' => 'h_type',
                        'type' => 'dropdown',
                        'heading' => __('Heading type', 'h22'),
                        'value' => array(
                            __('h2', 'h22') => 'h2',
                            __('h3', 'h22') => 'h3',
                            __('h4', 'h22') => 'h4',
                            __('h5', 'h22') => 'h5',
                            __('h6', 'h22') => 'h6',
                            __('h1', 'h22') => 'h1',
                            __('Span (non heading)', 'h22') => 'span',
                        ),
                        'group' => '',
                        'weight' => 10
                    ],
                    [
                        'param_name' => 'h_size',
                        'type' => 'dropdown',
                        'heading' => __('Heading size', 'h22'),
                        'value' => array(
                            __('Inherit', 'h22') => '',
                            __('Headline (h1)', 'h22') => 'h1',
                            __('Title (h2)', 'h22') => 'h2',
                            __('SubTitle (h3)', 'h22') => 'h3',
                            __('Body Title (h4-h6)', 'h22') => 'h4',
                            __('Display 1', 'h22') => 'o-display-1',
                            __('Display 2', 'h22') => 'o-display-2',
                            __('Caption (Small)', 'h22') => 'o-text-caption',
                        ),
                        'group' => '',
                        'weight' => 10
                    ],
                    [
                        'param_name' => 'h_class',
                        'type' => 'textfield',
                        'heading' => __('Add additional CSS classes', 'h22'),
                        'value' => '',
                        'group' => 'Settings'
                    ]
                ],
                'html_template' => dirname(__FILE__) . '/Heading.php',
            );
            $init = $this->initBaseController($settings);
            if ($init) {
                parent::__construct($settings);
            }
        }

        public function prepareData($data)
        {
            $data['attributes']['class'] = array();

            if (isset($data['h_src']) && $data['h_src'] === 'dynamic') {
                if (is_singular() || is_page() || is_single()) {
                    $data['h_content'] = get_the_title(get_queried_object_id());
                }

                if (is_archive()) {
                    $data['h_content'] = get_the_archive_title();
                }
            }

            $data['attributes']['class'][] = $data['h_class'] ?? false;
            $data['attributes']['class'][] = $data['h_size'] ?? false;

            if (!isset($data['h_type'])) {
                $data['h_type'] = 'h2';
            }

            return $data;
        }
    }
endif;
