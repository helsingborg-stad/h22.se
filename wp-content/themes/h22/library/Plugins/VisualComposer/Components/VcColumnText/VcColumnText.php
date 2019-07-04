<?php
namespace H22\Plugins\VisualComposer\Components\VcColumnText;

use H22\Plugins\VisualComposer\Components\BaseComponentController;
use H22\Plugins\VisualComposer\Components\GeneralComponentParams;

require_once WP_PLUGIN_DIR .
    '/js_composer/include/classes/shortcodes/vc-column-text.php';

if (
    !class_exists(
        '\H22\Plugins\VisualComposer\Components\VcColumnText\VcColumnText'
    )
):
    class VcColumnText extends \WPBakeryShortCode_VC_Column_text
    {
        use BaseComponentController;
        use GeneralComponentParams;

        public function __construct()
        {
            add_action('vc_after_init', array($this, 'changeTemplateSource'));
            add_action('vc_after_init', array($this, 'updateParams'));
            add_action('vc_after_init', array($this, 'addParams'));
            $this->initBaseController(false);
        }

        public function changeTemplateSource()
        {
            \WPBMap::modify(
                'vc_column_text',
                'html_template',
                dirname(__FILE__) . '/VcColumnText.php'
            );
        }

        public function updateParams()
        {
            vc_remove_param('vc_column_text', 'css');
            vc_remove_param('vc_column_text', 'css_animation');

            $param = \WPBMap::getParam('vc_column_text', 'content');
            \WPBMap::dropParam('vc_column_text', 'content');
            \WPBMap::addParam('vc_column_text', $param);

            $param = \WPBMap::getParam('vc_column_text', 'el_id');
            $param['group'] = __('Settings', 'h22');
            \WPBMap::dropParam('vc_column_text', 'el_id');
            \WPBMap::addParam('vc_column_text', $param);

            $param = \WPBMap::getParam('vc_column_text', 'el_class');
            $param['group'] = __('Settings', 'h22');
            \WPBMap::dropParam('vc_column_text', 'el_class');
            \WPBMap::addParam('vc_column_text', $param);
        }

        public function addParams()
        {
            vc_add_param('vc_column_text', [
                'type' => 'dropdown',
                'heading' => __('Text size', 'h22'),
                'param_name' => 'text_size',
                'value' => array(
                    __('Default', 'h22') => '',
                    __('Large', 'h22') => 'large',
                    __('Small', 'h22') => 'small',
                ),
            ]);

            $this->generalTextColorParams('vc_column_text', '', '');

            vc_add_param('vc_column_text', [
                'type' => 'dropdown',
                'heading' => __('Text size', 'h22'),
                'param_name' => 'text_size',
                'value' => array(
                    __('Default', 'h22') => '',
                    __('Large', 'h22') => 'large',
                    __('Small', 'h22') => 'small',
                ),
            ]);

            vc_add_param('vc_column_text', [
                'type' => 'dropdown',
                'heading' => __('Max width', 'h22'),
                'param_name' => 'max_width',
                'value' => array(
                    __('Content container (default)', 'h22') => '',
                    __('Container', 'h22') => 'container',
                    __('Small', 'h22') => 'small',
                    __('Wide', 'h22') => 'wide',
                    __('Full width', 'h22') => 'full-width',
                ),
            ]);

            vc_add_param('vc_column_text', [
                'type' => 'dropdown',
                'heading' => __('Container position (Horizontal)', 'h22'),
                'param_name' => 'container_pos',
                'value' => array(
                    __('Center (default)', 'h22') => '',
                    __('Left', 'h22') => 'left',
                    __('Right', 'h22') => 'right',
                ),
                'dependency' => array(
                    'element' => 'max_width',
                    'value' => array('', 'container', 'small', 'wide'),
                )
            ]);
        }

        public function prepareData($data)
        {
            // Format paragraphs etc
            $data['content'] = wpautop($data['content'], false);

            $data['attributes']['class'][] = 'c-column-text';
            $data['attributes']['class'][] = isset($data['el_class']) ? $data['el_class'] : '';
            $data['attributes']['class'][] = 'article';

            // Text size
            if (isset($data['text_size']) && !empty($data['text_size'])) {
                $data['attributes']['class'][] = 'article--text-' . $data['text_size'];
            }

            // Text Color
            if (isset($data['text_color']) && !empty($data['text_color'])) {
                if ($data['text_color'] === 'custom') {
                    $data['attributes']['style']['color'] = $data['text_color_hex'] ?? '';
                } else {
                    $data['attributes']['class'][] = 'u-text-' . $data['text_color'];
                }
            }

            // Container
            $data['attributes']['class'][] = 'container';
            if (!isset($data['max_width']) || empty($data['max_width'])) {
                $data['attributes']['class'][] = 'container--content';
            } elseif (isset($data['max_width']) && $data['max_width'] !== 'container') {
                $data['attributes']['class'][] = 'container--' . $data['max_width'];
            }

            if (isset($data['container_pos']) && !empty(($data['container_pos']))) {
                $containerPosClasses = array(
                    'left' => 'u-ml-0',
                    'right' => 'u-mr-0',
                );

                $data['attributes']['class'][] = isset($containerPosClasses[$data['container_pos']]) ?
                $containerPosClasses[$data['container_pos']] : '';
            }

            return $data;
        }
    }
endif;

/**
 * From wp-content/plugins/js_composer/include/templates/shortcodes/vc_column_text.php
 */
if (isset($atts)):
    $row = new VcColumnText();
    echo $row->output($atts, $content, 'vc_column_text');
endif;
