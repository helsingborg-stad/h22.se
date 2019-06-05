<?php
namespace H22\Plugins\VisualComposer\Components\Card;

use H22\Plugins\VisualComposer\Components\BaseComponentController;

if (!class_exists('\H22\Plugins\VisualComposer\Components\Card\Card')):
	class Card extends \WPBakeryShortCode {
		use BaseComponentController;

		public function __construct() {
			$settings = array(
				'name' => __('Card', 'h22'),
				'base' => 'vc_h22_card',
				'class' => '',
				'icon' => 'vc_icon-vc-gitem-post-excerpt',
				'description' => __('Card', 'h22'),
				'category' => __('Content', 'js_composer'),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => __('Heading', 'h22'),
						'param_name' => 'heading',
					),
					array(
						'type' => 'textarea_html',
						'holder' => 'div',
						'heading' => __('Text', 'h22'),
						'param_name' => 'content',
					),
					array(
						'type' => 'vc_link',
						// 'holder' => 'div',
						'heading' => __('Link', 'h22'),
						'param_name' => 'link',
					),
					array(
						'type' => 'attach_image',
						'heading' => __('Image', 'h22'),
						'param_name' => 'image_attachment',
						'value' => '',
						'group' => __('Graphics', 'h22'),
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Image ratio', 'h22'),
						'param_name' => 'image_ratio',
						'value' => array(
							__('4:3 – default', 'h22') => '4by3',
							__('16:9', 'h22') => '16by9',
							__('1:1', 'h22') => '1by1',
						),
						'description' => __('Select an image ratio for the card', 'h22'),
						// Sets default value
						'std' => '4by3',
						'group' => __('Graphics', 'h22'),
					),
					array(
						'type' => 'dropdown',
						'heading' => __('Align content', 'h22'),
						'param_name' => 'align_content',
						'value' => array(
							__('Left – default', 'h22') => 'left',
							__('Center', 'h22') => 'center',
							__('Right', 'h22') => 'right',
						),
						'description' => __('Select an alignement for your content', 'h22'),
						// Sets default value
						'std' => 'left',
						'group' => __('Settings', 'h22'),
					),
					array(
						'type' => 'el_id',
						'heading' => __('Element ID', 'js_composer'),
						'param_name' => 'el_id',
						'description' => sprintf(
							__(
								'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).',
								'js_composer'
							),
							'http://www.w3schools.com/tags/att_global_id.asp'
						),
						'group' => __('Settings', 'h22'),
					),
					array(
						'type' => 'textfield',
						'heading' => __('Extra class name', 'js_composer'),
						'param_name' => 'el_class',
						'value' => '',
						'description' => __(
							'Style particular content element differently - add a class name and refer to it in custom CSS.',
							'js_composer'
						),
						'group' => __('Settings', 'h22'),
					),
				),
				'html_template' => dirname(__FILE__) . '/Card.php',
			);
			$init = $this->initBaseController($settings);
			if ($init) {
				parent::__construct($settings);
			}
		}
		public function prepareData($data) {
			// Parent Attributes
			$attributes = [
				'class' => ['c-card'],
			];

			$data['link'] = vc_build_link($data['link']);

			if (!empty($data['link']['url'])) {
				$attributes['class'][] = 'c-card--clickable';
			}

			// Custom Ids
			if (isset($data['el_id'])) {
				$attributes['id'][] = $data['el_id'];
			}

			// Custom classes
			if (isset($data['el_class'])) {
				$attributes['class'][] = $data['el_class'];
			}

			//Content alignement
			$attributes['class'][] = 'c-card--' . ($data['align_content'] ?: 'left');

			$data['attributes'] = $attributes;

			// Link
			$link_attributes = [
				'target' => $data['link']['target'] ?: null,
				'rel' => $data['link']['rel'] ?: null,
				'title' => $data['link']['title'] ?: null,
			];
			$data['link']['attributes'] = $link_attributes;

			// Image_attachment
			$image_attributes = [
				'class' => ['c-card__image'],
			];

			if (isset($data['image_attachment'])) {
				$data['image'] = wp_get_attachment_metadata($data['image_attachment']);
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

				$data['image']['attributes'] = $image_attributes;
			}

			// Image ratio
			$image_wrapper_attributes = [
				'class' => [
					'c-card__image-wrapper',
					'c-card__image-wrapper--' . ($data['image_ratio'] ?: '4by3'),
				],
			];

			$data['image_wrapper']['attributes'] = $image_wrapper_attributes;
			return $data;
		}
	}
endif;
