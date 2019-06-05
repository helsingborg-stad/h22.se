<?php
namespace H22\Plugins\VisualComposer\Components\VCColumn;

use H22\Plugins\VisualComposer\Components\BaseComponentController;
use WPBMap;

if (!class_exists('\H22\Plugins\VisualComposer\Components\VCColumn\VCColumn')):
    class VCColumn
    {
        use BaseComponentController;

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
                dirname(__FILE__) . '/VCColumn.php'
            );
        }

        public function adminJS()
        {
            \WPBMap::modify('vc_column', 'js_view', 'ViewVCColumnModule');
            \WPBMap::modify(
                'vc_column',
                'admin_enqueue_js',
                \H22\Helper\FileSystem::themeUrl(dirname(__FILE__)) . '/js/vc_column.js'
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
            vc_add_param('vc_column', [
                'param_name' => 'color_theme',
                'type' => 'dropdown',
                'heading' => __('Color theme', 'h22'),
                'description' => __(
                    'Only applicable for columns inside sections.',
                    'h22'
                ),
                'value' => array(
                    __('Default (inherit)', 'h22') => '',
                    __('Red text', 'h22') => 'red',
                    __('Green text', 'h22') => 'green',
                    __('Blue text', 'h22') => 'blue',
                    __('Purple text', 'h22') => 'purple',
                    __('Red background', 'h22') => 'bg-red',
                    __('Green background', 'h22') => 'bg-green',
                    __('Blue background', 'h22') => 'bg-blue',
                    __('Purple background', 'h22') => 'bg-purple',
                ),
                'std' => '',
            ]);

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
                'heading' => __('Vertical alignment', 'h22'),
                'param_name' => 'vertical_align',
                'value' => array(
                    __('Top', 'h22') => 'top',
                    __('Middle', 'h22') => 'middle',
                    __('Bottom', 'h22') => 'bottom',
                ),
                'std' => 'top',
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
        }

        public function prepareData($data)
        {
            $data['attributes']['class'][] = 'c-column';

            if ($el_id = $data['el_id'] ?? null) {
                $data['attributes']['id'] = $el_id;
            }

            if ($el_class = $data['el_class'] ?? null) {
                $data['attributes']['class'][] = $el_class;
            }

            if ($color_theme = $data['color_theme'] ?? null) {
                $data['attributes']['class'][] = "c-column--color-theme-{$color_theme}";
            }

            if ($vertical_align = $data['vertical_align'] ?? null) {
                $data['attributes']['class'][] = "c-column--align-{$vertical_align}";
            }

            if ($text_align = $data['text_align'] ?? null) {
                $data['attributes']['class'][] = "c-column--text-align-{$text_align}";
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
    $element = new VCColumn();
    echo $element->output($atts, $content, 'vc_column');
endif;
