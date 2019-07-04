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
            add_action('vc_after_init', array($this, 'changeTemplateSource'));
            add_action('vc_after_init', array($this, 'adminJS'));
            add_action('vc_after_init', array($this, 'removeParams'));
            add_action('vc_after_init', array($this, 'updateParams'));
            add_action('vc_after_init', array($this, 'addParams'));

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
            // vc_remove_param('vc_column', 'offset');
            vc_remove_param('vc_column', 'video_bg');
            vc_remove_param('vc_column', 'video_bg_url');
            vc_remove_param('vc_column', 'video_bg_parallax');
            vc_remove_param('vc_column', 'parallax');
            vc_remove_param('vc_column', 'parallax_image');
            vc_remove_param('vc_column', 'parallax_speed_video');
            vc_remove_param('vc_column', 'parallax_speed_bg');
            // vc_remove_param('vc_column', 'width');
        }

        public function updateParams()
        {
            // Custom param type override
            $param = WPBMap::getParam('vc_column', 'offset');
            $param['type'] = 'column_offset_mod';
            WPBMap::mutateParam('vc_column', $param);

            // Remove width options
            $param = WPBMap::getParam('vc_column', 'width');
            unset($param['value']['20% - 1/5']);
            unset($param['value']['40% - 2/5']);
            unset($param['value']['60% - 3/5']);
            unset($param['value']['80% - 4/5']);
            WPBMap::mutateParam('vc_column', $param);

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
        }

        public function addParams()
        {
            $this->generalThemeParams('vc_column');
            $this->generalBackgroundParams('vc_column');
            $this->generalTextColorParams('vc_column');

            vc_add_param('vc_column', [
                'type' => 'dropdown',
                'heading' => __('Text alignment', 'h22'),
                'param_name' => 'text_align',
                'value' => array(
                    __('Left (default)', 'h22') => '',
                    __('Center', 'h22') => 'center',
                    __('Right', 'h22') => 'right',
                ),
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
                'heading' => __('Element alignment (vertical)', 'h22'),
                'param_name' => 'vertical_align',
                'value' => array(
                    __('Top (default)', 'h22') => '',
                    __('Middle', 'h22') => 'middle',
                    __('Bottom', 'h22') => 'bottom',
                ),
            ]);

            vc_add_param('vc_column', [
                'type' => 'dropdown',
                'heading' => __('Element spacing', 'h22'),
                'param_name' => 'el_spacing',
                'value' => array(
                    __('Default', 'h22') => '',
                    __('Small', 'h22') => 'small',
                    __('None', 'h22') => 'none',
                )
            ]);

            vc_add_param('vc_column', [
                'type' => 'dropdown',
                'heading' => __('Inner column padding', 'h22'),
                'param_name' => 'inner_pad',
                'value' => array(
                    __('Inherit (default)', 'h22') => '',
                    __('No padding', 'h22') => '0',
                    __('Padding 24', 'h22') => '3',
                    __('Padding 40', 'h22') => '5',
                    __('Padding 56', 'h22') => '7',
                )
            ]);

            vc_add_param('vc_column', [
                'type' => 'textfield',
                'heading' => __('Extra Inner column class name', 'h22'),
                'param_name' => 'inner_class',
                'value' => '',
                'group' => 'Settings',
                'weight' => -100
            ]);
        }

        public function prepareData($data)
        {
            $data['attributes']['class'][] = 'c-column';
            $data['childAttributes']['class'][] = 'c-column__inner';
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

            // Column Width main breakpoint
            $width = $data['width'] ?? '1/1';
            list($a, $b) = explode('/', $width);
            $cols = intval((12 * $a) / $b);
            $data['attributes']['class'][] = "grid-md-$cols";

            // Column width, offset & hide @ all breakpoints
            if (isset($data['offset']) && !empty($data['offset'])) {
                $data['offset'] = str_replace('vc_col-lg-offset', 'offset-lg', $data['offset']);
                $data['offset'] = str_replace('vc_col-md-offset', 'offset-md', $data['offset']);
                $data['offset'] = str_replace('vc_col-sm-offset', 'offset-sm', $data['offset']);
                $data['offset'] = str_replace('vc_col-xs-offset', 'offset-xs', $data['offset']);

                $data['offset'] = str_replace('vc_col-', 'grid-', $data['offset']);
                $data['offset'] = str_replace('vc_hidden-', 'hidden@', $data['offset']);

                foreach (explode(' ', $data['offset']) as $gridClass) {
                    $data['attributes']['class'][] = $gridClass;
                }
            }

            // Inner padding
            if (isset($data['inner_pad']) && $data['inner_pad'] !== '') {
                $data['childAttributes']['class'][] = 'u-p-' . $data['inner_pad'];

                if (strpos($data['color_theme'], 'fill') !== false) {
                    $data['childAttributes']['class'][] = 'has-fill';
                }
            }

            // Element vertical align
            if (isset($data['vertical_align']) && $data['vertical_align'] !== '' && $data['vertical_align'] !== 'top') {
                $verticalAlignClasses = [
                    'middle' => 'u-justify-content-center',
                    'bottom' => 'u-justify-content-end'
                ];

                $data['childAttributes']['class'][] = $verticalAlignClasses[$data['vertical_align']] ?? '';
            }

            // Text align
            if ($text_align = $data['text_align'] ?? null) {
                $data['attributes'][
                    'class'
                ][] = "c-column--text-align-{$text_align}";
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
            
            // Featured Image as Background Image Source
            if (isset($data['bg_image_src']) && $data['bg_image_src'] === 'featured_image') {
                $data['bg_image'] = get_post_thumbnail_id(get_queried_object_id());
                $data['bg_image'] = apply_filters('H22/Plugins/VisualComposer/Components/VcColumn/bgImage', $data['bg_image']);
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
