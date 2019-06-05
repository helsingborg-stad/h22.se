<?php
namespace H22\Plugins\VisualComposer\Components;

use Philo\Blade\Blade as Blade;
use H22\Plugins\VisualComposer\ActiveComponents as ActiveComponents;
/*
    This class is almost the same as BaseComponentController except it must extend WPBakeryShortCodesContainer and in the output function scan for nested shortcodes to evaluate
*/
abstract class ContainerComponentController extends
	\WPBakeryShortCodesContainer {
	protected $vcSettings = array();

	protected $class_info = false;
	protected $bladeViewPaths = array();
	protected $bladeCachePath = false;
	protected $bladeView = 'ContainerComponentcontroller';
	protected $componentBaseName = 'ContainerComponentController';

	public function __construct($settings) {
		$className = str_replace('\\', '/', get_class($this)); // Convert backslash to forwardslash
		$this->componentBaseName = basename($className);
		$this->bladeView = strtolower($this->componentBaseName);
		$this->bladeViewPaths[] =
			get_stylesheet_directory() .
			'/bem-views/vc-components/' .
			$this->componentBaseName;
		$this->bladeViewPaths[] =
			get_stylesheet_directory() .
			'/views/vc-components/' .
			$this->componentBaseName;
		if (!$this->class_info) {
			$this->class_info = $this->getClassSource();
		}
		$this->bladeViewPaths[] =
			dirname($this->class_info->getFileName()) . '/views';
		$this->bladeCachePath = WP_CONTENT_DIR . '/uploads/cache/blade-cache';

		if (!empty($settings) && is_array($settings)) {
			$this->vcSettings = $settings;
			$this->vcSettings['php_class_name'] = get_class($this);
			$this->vcSettings = apply_filters(
				'helsingborg-h22/visual-composer/' . $this->bladeView . '/vcSettings',
				$this->vcSettings
			);
			vc_map($this->vcSettings);

			ActiveComponents::getInstance()->addComponent($this->vcSettings['base']);

			parent::__construct($this->vcSettings);
		}
	}

	/*
        Returns the class that is considered the root of the component.
     */
	protected function getClassSource() {
		return new \ReflectionClass($this);
	}

	protected function setViewPaths() {
		$this->bladeViewPaths = apply_filters(
			'helsingborg-h22/visual-composer/viewPath',
			$this->bladeViewPaths,
			$this->vcSettings
		);
		$this->bladeViewPaths = apply_filters(
			'helsingborg-h22/visual-composer/' . $this->bladeView . '/viewPath',
			$this->bladeViewPaths,
			$this->vcSettings
		); // e.g. helsingborg-h22/visual-composer/card/viewPath
		$this->bladeViewPaths = array_unique($this->bladeViewPaths);
	}

	public function output($atts, $content = null, $shortcode_name = '') {
		$content = wpb_js_remove_wpautop($content);
		if (!is_array($atts)) {
			$atts = array();
		}
		$this->setViewPaths();
		$data = array_merge($atts, array(
			'content' => $content,
		));
		// e.g. helsingborg-h22/visual-composer/card/data
		$data = apply_filters(
			'helsingborg-h22/visual-composer/' . $this->bladeView . '/data',
			$data,
			$atts,
			$content,
			$shortcode_name,
			$this->vcSettings
		);

		$blade = new Blade($this->bladeViewPaths, $this->bladeCachePath);
		return $blade
			->view()
			->make($this->bladeView, $data)
			->render();
	}
}
