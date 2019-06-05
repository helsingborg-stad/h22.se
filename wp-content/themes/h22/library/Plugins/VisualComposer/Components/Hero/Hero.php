<?php
namespace H22\Plugins\VisualComposer\Components\Hero;

if (!class_exists('\H22\Plugins\VisualComposer\Components\Hero\Hero')):
    class Hero extends \WPBakeryShortCode
    {
        use \H22\Plugins\VisualComposer\Components\BaseComponentController;
        public function __construct()
        {
            $settings = array(
                'name' => __('Hero', 'h22'),
                'base' => 'vc_h22_hero',
                'icon' => 'icon-wpb-ui-empty_space',
                'params' => array(
                    array(
                        'type' => 'dropdown',
                        'param_name' => 'hero_type',
                        'heading' => __('Hero type', 'h22'),
                        'value' => array(
                            __('Text', 'h22') => 'text',
                            __('Text with Background image', 'h22') => 'text-with-bg-image',
                            __('Image', 'h22') => 'with-bg-image',
                        ),
                        'description' => 'Choose the minimum height for the hero',
                        'std' => 'text',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Heading', 'h22'),
                        'param_name' => 'heading',
                        'dependency' => array(
                            'element' => 'hero_type',
                            'value' => array('text', 'text-with-bg-image'),
                        ),
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => __('Body', 'h22'),
                        'param_name' => 'body',
                        'dependency' => array(
                            'element' => 'hero_type',
                            'value' => array('text', 'text-with-bg-image'),
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'param_name' => 'min_height',
                        'heading' => __('Minimum height', 'h22'),
                        'value' => array(
                            __('None', 'h22') => '',
                            __('Small', 'h22') => 'sm',
                            __('Medium', 'h22') => 'md',
                            __('Large', 'h22') => 'lg',
                            __('X-Large', 'h22') => 'xl',
                        ),
                        'description' => 'Choose the minimum height for the hero',
                        'std' => '',
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => __('Background image', 'h22'),
                        'description' => __(
                            'Sets a background image for the entire row, use with moderation. Hint, don\'t build rows that will grow too much in height',
                            'h22'
                        ),
                        'param_name' => 'image_attachment',
                        'value' => '',
                        'dependency' => array(
                            'element' => 'hero_type',
                            'value' => array('text-with-bg-image', 'with-bg-image'),
                        ),
                    ),
                    array(
                        'param_name' => 'overlay',
                        'type' => 'checkbox',
                        'heading' => __('Overlay', 'h22'),
                        'description' => __(
                            'If checked an overlay will be added on the background image',
                            'h22'
                        ),
                        'value' => array(
                            __('Yes', 'h22') => 'yes',
                        ),
                        'dependency' => array(
                            'element' => 'hero_type',
                            'value' => array('text-with-bg-image'),
                        ),
                    ),
                    array(
                        'param_name' => 'color_theme',
                        'type' => 'dropdown',
                        'heading' => __('Color theme', 'h22'),
                        'value' => array(
                            __('Black text', 'h22') => 'black',
                            __('Red background', 'h22') => 'bg-red',
                            __('Green background', 'h22') => 'bg-green',
                            __('Blue background', 'h22') => 'bg-blue',
                            __('Purple background', 'h22') => 'bg-purple',
                        ),
                        'dependency' => array(
                            'element' => 'hero_type',
                            'value' => array('text'),
                        ),
                        'std' => 'black',
                    ),
                ),
                'html_template' => dirname(__FILE__) . '/Hero.php',
            );
            $init = $this->initBaseController($settings);
            if ($init) {
                parent::__construct($settings);
            }
        }

        public function prepareData($data)
        {
            $data['attributes']['class'][] = 'c-hero';

            $hero_type = $data['hero_type'] ?? 'text';
            if ($hero_type !== 'text') {
                $data['attributes']['class'][] = empty($data['overlay'])
                    ? "c-hero--{$data['hero_type']}"
                    : 'c-hero--text-with-bg-image-overlay';
            }

            if (isset($data['image_attachment'])) {
                $data['background_image'] = wp_get_attachment_metadata(
                    $data['image_attachment']
                );

                $image_attributes['class'][] = 'c-hero__image';

                $image_attributes['src'] = wp_get_attachment_url(
                    $data['image_attachment']
                );

                $image_attributes['srcset'] = wp_get_attachment_image_srcset(
                    $data['image_attachment']
                );
                $image_attributes['alt'] = get_post_meta(
                    $data['image_attachment'],
                    '_wp_attachment_image_alt',
                    true
                );

                $data['background_image']['attributes'] = $image_attributes;
            }

            if (!empty($data['min_height'])) {
                $data['attributes']['class'][] = "u-min-height-{$data['min_height']}";
            }

            $color_theme = $data['color_theme'] ?? 'black';
            if ($hero_type == 'text') {
                $data['attributes']['class'][] = "c-hero--color-theme-{$color_theme}";
            }

            $data['attributes']['class'] = array_filter($data['attributes']['class']);
            $data = array_filter($data);

            return $data;
        }
    }
endif;
