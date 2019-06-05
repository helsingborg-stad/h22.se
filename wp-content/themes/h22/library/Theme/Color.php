<?php

namespace H22\Theme;

use H22\Helper\Styleguide as Styleguide;

class Color {
	public function __construct() {
		// add_action('after_setup_theme', array($this, 'initCustomColorSchemes'));
		add_filter('body_class', array($this, 'removeBoxShadows'), 10, 1);
	}

	public function setCustomThemeColors($colors) {
		if (Styleguide::isCustomTheme()) {
			$hbgFilePath =
				get_stylesheet_directory() .
				'/assets/source/custom-hbg-prime/' .
				Styleguide::getCurrentTheme() .
				'.scss';
			$hbgStyleguideInfo = get_file_data(
				$hbgFilePath,
				array(
					'$palette-1' => '$palette-1',
					'$palette-1-text' => '$palette-1-text',
					'$palette-2' => '$palette-2',
					'$palette-2-text' => '$palette-2-text',
					'$palette-3' => '$palette-3',
					'$palette-3-text' => '$palette-3-text',
					'$palette-4' => '$palette-4',
					'$palette-4-text' => '$palette-4-text',
					'$palette-5' => '$palette-5',
					'$palette-5-text' => '$palette-5-text',
				),
				''
			);
			return $hbgStyleguideInfo;
		}
		return $colors;
	}

	public function removeBoxShadows($classes) {
		$classes[] = 'material-no-shadow';
		return $classes;
	}

	public function initCustomColorSchemes() {
		add_filter(
			'acf/load_field/name=color_scheme',
			array($this, 'appendThemes'),
			10,
			1
		);
	}

	public function appendThemes($field) {
		$choices = $field['choices'];

		$choices[Styleguide::$THEME_H22] = __('H22', 'h22');

		$field['choices'] = $choices;
		return $field;
	}
}
