<?php
namespace H22\Plugins\VisualComposer\Components\ButtonGroup;

if (
	!class_exists(
		'\H22\Plugins\VisualComposer\Components\ButtonGroup\ButtonGroup'
	)
):
	class ButtonGroup extends \WPBakeryShortCode {
		use \H22\Plugins\VisualComposer\Components\BaseComponentController;
		public function __construct() {
			$settings = array(
				'name' => __('Button Group', 'h22'),
				'base' => 'vc_h22_button_group',
				'icon' => 'icon-wpb-row',
				'params' => array(
					array(
						'type' => 'vc_link',
						'heading' => __('Button link', 'h22'),
						'description' => __('Add the button link ', 'h22'),
						'param_name' => 'button_1_link',
						'group' => __('Button 1', 'h22'),
					),
					array(
						'type' => 'el_id',
						'heading' => __('Button Id', 'h22'),
						'description' => sprintf(
							__(
								'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).',
								'js_composer'
							),
							'http://www.w3schools.com/tags/att_global_id.asp'
						),
						'param_name' => 'button_1_el_id',
						'group' => __('Button 1', 'h22'),
					),
					array(
						'type' => 'textfield',
						'heading' => __('Button class', 'h22'),
						'value' => '',
						'description' => __(
							'Style particular content element differently - add a class name and refer to it in custom CSS.',
							'js_composer'
						),
						'param_name' => 'button_1_el_class',
						'group' => __('Button 1', 'h22'),
					),
					array(
						'type' => 'vc_link',
						'heading' => __('Button link', 'h22'),
						'description' => __('Add the button link ', 'h22'),
						'param_name' => 'button_2_link',
						'group' => __('Button 2', 'h22'),
					),
					array(
						'type' => 'el_id',
						'heading' => __('Button Id', 'h22'),
						'description' => sprintf(
							__(
								'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).',
								'js_composer'
							),
							'http://www.w3schools.com/tags/att_global_id.asp'
						),
						'param_name' => 'button_2_el_id',
						'group' => __('Button 2', 'h22'),
					),
					array(
						'type' => 'textfield',
						'heading' => __('Button class', 'h22'),
						'value' => '',
						'description' => __(
							'Style particular content element differently - add a class name and refer to it in custom CSS.',
							'js_composer'
						),
						'param_name' => 'button_2_el_class',
						'group' => __('Button 2', 'h22'),
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Placement', 'h22'),
						'param_name' => 'button_group_placement',
						'value' => array(
							__('Left – default', 'h22') => 'left',
							__('Center', 'h22') => 'center',
							__('Right', 'h22') => 'right',
						),
						'description' => __(
							'Choose the placement of your button group',
							'h22'
						),

						// Sets default value
						'std' => 'left',
						'group' => __('Button group settings', 'h22'),
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Placement', 'h22'),
						'param_name' => 'button_group_color',
						'value' => array(
							__('Default', 'h22') => 'default',
							__('Inverted', 'h22') => 'inverted',
						),
						'description' => __(
							'Choose the color of your button group',
							'h22'
						),

						// Sets default value
						'std' => 'default',
						'group' => __('Button group settings', 'h22'),
					),
				),
				'html_template' => dirname(__FILE__) . '/ButtonGroup.php',
			);
			$init = $this->initBaseController($settings);
			if ($init) {
				parent::__construct($settings);
			}
		}

		public function prepareData($data) {
			// button group
			$buttons = array('button_1', 'button_2');

			foreach ($data as $key => $value) {
				if ($key !== 'button_group_placement') {
					foreach ($buttons as $button) {
						if (strpos($key, $button) === 0) {
							$newKey = str_replace($button . '_', '', $key);

							$data['buttons'][$button][$newKey] = $value;
						}
					}
				}
			}

			foreach ($data['buttons'] as &$button) {
				if (empty(vc_build_link($button['link'])['url'])) {
					$button = null;
					continue;
				}
				$button['attributes']['id'] = $button['el_id'];

				$button['attributes']['class'][] = 'c-button-group__link';
				$button['attributes']['class'][] =
				$data['button_group_color'] ?
				'c-button-group__link--' . $data['button_group_color']
				: 'c-button-group__link--default';
				$button['attributes']['class'][] = $button['el_class'];

				$button['attributes']['href'] = vc_build_link($button['link'])['url'];
				$button['attributes']['target'] =
					vc_build_link($button['link'])['target'] ?: null;
				$button['label'] = vc_build_link($button['link'])['title'];
			}

			$data['buttons'] = array_filter($data['buttons']);
			$data['button_group_placement'] =
				$data['button_group_placement'] ?? 'left';

			return $data;
		}
	}
endif;
