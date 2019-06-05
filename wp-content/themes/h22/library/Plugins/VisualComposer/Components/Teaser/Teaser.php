<?php
namespace H22\Plugins\VisualComposer\Components\Teaser;

use H22\Plugins\VisualComposer\Components\BaseComponentController;

if (!class_exists('\H22\Plugins\VisualComposer\Components\Teaser\Teaser')):
	class Teaser extends \WPBakeryShortCode {
		use BaseComponentController;

		public function __construct() {
			$settings = [
				'name' => __('Teaser', 'h22'),
				'base' => 'vc_h22_teaser',
				'class' => '',
				'icon' => 'vc_icon-vc-gitem-post-excerpt',
				'description' => __('Teaser', 'h22'),
				'category' => __('Content', 'js_composer'),
				'params' => [
					[
						'type' => 'textfield',
						'heading' => __('Meta heading', 'h22'),
						'param_name' => 'meta_heading',
					],
					[
						'type' => 'textfield',
						'heading' => __('Heading', 'h22'),
						'param_name' => 'heading',
					],
					[
						'type' => 'textarea',
						// 'holder' => 'div',
						'heading' => __('Preamble', 'h22'),
						'param_name' => 'preamble',
					],
					[
						'type' => 'textarea_html',
						'holder' => 'div',
						'heading' => __('Text', 'h22'),
						'param_name' => 'content',
					],
					[
						'type' => 'vc_link',
						'heading' => __('Link', 'h22'),
						'param_name' => 'link',
					],
				],
				'html_template' => dirname(__FILE__) . '/Teaser.php',
			];
			$init = $this->initBaseController($settings);
			if ($init) {
				parent::__construct($settings);
			}
		}

		public function prepareData($data) {
			$data['attributes']['class'][] = 'c-teaser';

			if (!empty($data['link'])) {
				$link = vc_build_link($data['link']);
				if ($link['url'] ?? null) {
					$data['link'] = [];
					$data['link']['attributes']['class'][] = 'cta-link';
					$data['link']['attributes']['href'] = $link['url'];
					$data['link']['attributes']['target'] = $link['target'] ?? null;
					$data['link']['text'] = $link['title'] ?? '';
				} else {
					unset($data['link']);
				}
			}

			return $data;
		}
	}
endif;
