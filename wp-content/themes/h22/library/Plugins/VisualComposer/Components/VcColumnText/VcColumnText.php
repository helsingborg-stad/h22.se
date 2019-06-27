<?php
namespace H22\Plugins\VisualComposer\Components\VcColumnText;

use H22\Plugins\VisualComposer\Components\BaseComponentController;

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

        public function __construct()
        {
            add_action('vc_after_init', array($this, 'changeTemplateSource'));
            add_action('vc_after_init', array($this, 'changeParams'));
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

        public function addParams()
        {
            vc_add_param('vc_column_text', [
                'type' => 'checkbox',
                'heading' => __('Expand to full width', 'h22'),
                'param_name' => 'full_width',
                'value' => '',
                'weight' => 0
            ]);
        }
        public function changeParams()
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

        public function prepareData($data)
        {
            $data['attributes']['class'][] = 'c-column-text';
            $data['attributes']['class'][] = isset($data['el_class']) ? $data['el_class'] : '';
            $data['attributes']['class'][] = 'article';

            if (!isset($data['full_width']) || $data['full_width'] !== 'true') {
                $data['attributes']['class'][] = 'container container--content';
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
