<?php
namespace H22\Plugins\VisualComposer\Components\VCColumnText;

use H22\Plugins\VisualComposer\Components\BaseComponentController;

require_once WP_PLUGIN_DIR .
	'/js_composer/include/classes/shortcodes/vc-column-text.php';

if (
	!class_exists(
		'\H22\Plugins\VisualComposer\Components\VCColumnText\VCColumnText'
	)
):
	class VCColumnText extends \WPBakeryShortCode_VC_Column_text {
		use BaseComponentController;

		public function __construct() {
			add_action('vc_after_init', array($this, 'changeTemplateSource'));
			add_action('vc_after_init', array($this, 'changeParams'));
			$this->initBaseController(false);
		}

		public function changeTemplateSource() {
			\WPBMap::modify(
				'vc_column_text',
				'html_template',
				dirname(__FILE__) . '/VCColumnText.php'
			);
		}

		public function changeParams() {
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

		public function prepareData($data) {
			$data['attributes']['class'][] = 'c-column-text';
			$data['attributes']['class'][] = 'container';
			return $data;
		}
	}
endif;

/**
 * From wp-content/plugins/js_composer/include/templates/shortcodes/vc_column_text.php
 */
if (isset($atts)):
	$row = new VCColumnText();
	echo $row->output($atts, $content, 'vc_column_text');
endif;
