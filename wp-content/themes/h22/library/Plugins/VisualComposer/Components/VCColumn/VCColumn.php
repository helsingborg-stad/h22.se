<?php
namespace H22\Plugins\VisualComposer\Components\VcColumn;

use H22\Plugins\VisualComposer\Components\BaseComponentController;
use H22\Plugins\VisualComposer\Components\GeneralComponentParams;

use WPBMap;

if (!class_exists('\H22\Plugins\VisualComposer\Components\VcColumn\VcColumn')) :
    class VcColumn
    {
        use BaseComponentController;
        use GeneralComponentParams;

        public function __construct()
        {
            add_action('vc_after_init', array($this, 'adminJS'));
            add_action('vc_after_init', array($this, 'changeTemplateSource'));
            add_action('vc_after_init', array($this, 'removeParams'));
            add_action('vc_after_init', array($this, 'addParams'));
            add_action('vc_after_init', array($this, 'updateParams'));
            $this->initBaseController(false);
        }

        public function changeTemplateSource()
        {
            \WPBMap::modify(
                'vc_column',
                'html_template',
                dirname(__FILE__) . '/VcColumn.php'
            );
        }

        public function adminJS()
        {
            \WPBMap::modify('vc_column', 'js_view', 'ViewVCColumnModule');
            \WPBMap::modify(
                'vc_column',
                'admin_enqueue_js',
                \H22\Helper\FileSystem::themeUrl(dirname(__FILE__)) .
                    '/js/vc_column.js'
            );
        }

        public function removeParams()
        {
            vc_remove_param('vc_column', 'css_animation');
            vc_remove_param('vc_column', 'css');
            vc_remove_param('vc_column', 'offset');
            vc_remove_param('vc_column', 'video_bg');
            vc_remove_param('vc_column', 'video_bg_url');
            vc_remove_param('vc_column', 'video_bg_parallax');
            vc_remove_param('vc_column', 'parallax');
            vc_remove_param('vc_column', 'parallax_image');
            vc_remove_param('vc_column', 'parallax_speed_video');
            vc_remove_param('vc_column', 'parallax_speed_bg');
            // vc_remove_param('vc_column', 'width');
        }

        public function addParams()
        {
            $this->generalThemeParams('vc_column');
            $this->generalBackgroundParams('vc_column');
            $this->generalTextColorParams('vc_column');

            vc_add_param('vc_column', [
                'type' => 'checkbox',
                'heading' => 'Hide this column on these screen sizes',
                'param_name' => 'hidden_sizes',
                'value' => [
                    __('Large', 'h22') => 'lg',
                    __('Medium', 'h22') => 'md',
                    __('Small', 'h22') => 'sm',
                    __('Extra small', 'h22') => 'xs',
                ],
                // 'group' => __('Responsive Options', 'js_composer'),
            ]);
        }

        public function updateParams()
        {
            $param = WPBMap::getParam('vc_column', 'width');
            $param['value'] = [
                __('1/2', 'h22') => '1/2',
                __('1/3', 'h22') => '1/3',
                __('2/3', 'h22') => '2/3',
                __('1/4', 'h22') => '1/4',
                __('3/4', 'h22') => '3/4',
                __('Whole row', 'h22') => '1/1',
            ];
            $param['group'] = null;
            WPBMap::mutateParam('vc_column', $param);

            vc_add_param('vc_column', [
                'type' => 'dropdown',
                'heading' => __('Text alignment', 'h22'),
                'param_name' => 'text_align',
                'value' => array(
                    __('Left', 'h22') => 'left',
                    __('Center', 'h22') => 'center',
                    __('Right', 'h22') => 'right',
                ),
                'std' => 'left',
            ]);

            vc_add_param('vc_column', [
                'type' => 'dropdown',
                'heading' => __('Container width', 'h22'),
                'param_name' => 'container',
                'value' => array(
                    __('Default', 'h22') => '',
                    __('Content', 'h22') => 'content',
                    __('Small', 'h22') => 'small',
                    __('Wide', 'h22') => 'wide',
                    __('Full width', 'h22') => 'full-width',
                ),
            ]);

            vc_add_param('vc_column', [
                'type' => 'dropdown',
                'heading' => __('Vertical alignment', 'h22'),
                'param_name' => 'vertical_align',
                'value' => array(
                    __('Top', 'h22') => 'top',
                    __('Middle', 'h22') => 'middle',
                    __('Bottom', 'h22') => 'bottom',
                ),
                'std' => 'top',
            ]);

            vc_add_param('vc_column', [
                'type' => 'dropdown',
                'heading' => __('Inner padding', 'h22'),
                'param_name' => 'inner_pad',
                'value' => array(
                    __('Default (inherit)', 'h22') => '',
                    __('No padding', 'h22') => '0',
                    __('Padding 24', 'h22') => '3',
                    __('Padding 40', 'h22') => '5',
                    __('Padding 56', 'h22') => '7',
                )
            ]);

            vc_add_param('vc_column', [
                'type' => 'checkbox',
                'heading' => __('Remove element spacing', 'h22'),
                'param_name' => 'no_space_el',
                'value' => 0
            ]);

            // Move param to separate tab and place it last by dropping and re-adding it
            $param = WPBMap::getParam('vc_column', 'el_id');
            $param['group'] = __('Settings', 'h22');
            WPBMap::dropParam('vc_column', $param['param_name']);
            WPBMap::addParam('vc_column', $param);

            // Move param to separate tab and place it last by dropping and re-adding it
            $param = WPBMap::getParam('vc_column', 'el_class');
            $param['group'] = __('Settings', 'h22');
            WPBMap::dropParam('vc_column', $param['param_name']);
            WPBMap::addParam('vc_column', $param);

            vc_add_param('vc_column', [
                'type' => 'textfield',
                'heading' => __('Extra Inner column class name', 'h22'),
                'param_name' => 'inner_class',
                'value' => '',
                'group' => 'Settings'
            ]);
        }

        public function prepareData($data)
        {
            $data['attributes']['class'][] = 'c-column';
            $data['childAttributes']['class'][] = 'column__inner';
            $data['childAttributes']['class'][] = $data['inner_class'] ?? '';

            if (isset($data['no_space_el']) && $data['no_space_el'] === 'true') {
                $data['childAttributes']['class'][] = 's-elements-mb-0';
            }

            if ($el_id = $data['el_id'] ?? null) {
                $data['attributes']['id'] = $el_id;
            }

            if ($el_class = $data['el_class'] ?? null) {
                $data['attributes']['class'][] = $el_class;
            }

            if (isset($data['vertical_align']) && $data['vertical_align'] !== '' && $data['vertical_align'] !== 'top') {
                $verticalAlignClasses = [
                    'middle' => 'u-justify-content-center',
                    'bottom' => 'u-justify-content-end'
                ];

                $data['childAttributes']['class'][] = $verticalAlignClasses[$data['vertical_align']] ?? '';
            }

            if ($text_align = $data['text_align'] ?? null) {
                $data['attributes'][
                    'class'
                ][] = "c-column--text-align-{$text_align}";
            }

            if (!empty($data['hidden_sizes'])) {
                $sizes = explode(',', $data['hidden_sizes']);
                foreach ($sizes as $size) {
                    $data['attributes']['class'][] = "u-display-none@$size";
                }
            }

            $width = $data['width'] ?? '1/1';
            list($a, $b) = explode('/', $width);
            $cols = intval((12 * $a) / $b);
            $data['attributes']['class'][] = "grid-md-$cols";

            // Inner padding
            if (isset($data['inner_pad']) && $data['inner_pad'] !== '') {
                $data['childAttributes']['class'][] = 'u-p-' . $data['inner_pad'];

                if (strpos($data['color_theme'], 'fill') !== false) {
                    $data['childAttributes']['class'][] = 'has-fill';
                }
            }

            // Color Theme
            if (isset($data['color_theme']) && !empty($data['color_theme'])) {
                $data['childAttributes']['class'][] = 't-' . $data['color_theme'];

                if (strpos($data['color_theme'], 'fill') !== false) {
                    $data['childAttributes']['class'][] = 'has-fill';
                }
            }

            // Text Color
            if (isset($data['text_color']) && !empty($data['text_color'])) {
                if ($data['text_color'] === 'custom') {
                    $data['childAttributes']['style']['color'] = $data['text_color_hex'] ?? '';
                } else {
                    $data['childAttributes']['class'][] = 'u-text-' . $data['text_color'];
                }
            }

            // Background Color
            if (isset($data['bg_color']) && !empty($data['bg_color'])) {
                if ($data['bg_color'] === 'custom') {
                    $data['childAttributes']['style']['background-color'] = $data['bg_color_hex'] ?? '';
                } else {
                    $data['childAttributes']['class'][] = 'u-bg-' . $data['bg_color'];
                }

                if (!in_array('has-fill', $data['childAttributes']['class'])) {
                    $data['childAttributes']['class'][] = 'has-fill';
                }
            }
            
            // Background image
            if (isset($data['bg_image']) && !empty($data['bg_image'])) {
                $data['childAttributes']['style']['background-image'] = "url('" . wp_get_attachment_url($data['bg_image']) . "')";
                $data['childAttributes']['style']['background-repeat'] = $data['bg_repeat'] ?? '';
                $data['childAttributes']['style']['background-size'] = $data['bg_size'] ?? '';
                $data['childAttributes']['style']['background-size'] = $data['bg_size_custom'] ?? $data['childAttributes']['style']['background-size'];
                $data['childAttributes']['style']['background-position'] = $data['bg_pos'] ?? '';
                $data['childAttributes']['style']['background-position'] = $data['bg_pos_custom'] ?? $data['childAttributes']['style']['background-position'];

                if (!in_array('has-fill', $data['childAttributes']['class'])) {
                    $data['childAttributes']['class'][] = 'has-fill';
                }
            }


            return $data;
        }
    }
endif;

/**
 * From wp-content/plugins/js_composer/include/templates/shortcodes/vc_column.php
 * Shortcode attributes
 * @var $atts
 * @var $el_id
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */
if (isset($atts)):
    $element = new VcColumn();
    echo $element->output($atts, $content, 'vc_column');
endif;
