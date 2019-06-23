<?php
namespace H22\Plugins\VisualComposer\Components;

use Doctrine\Common\Inflector\Inflector;
use H22\Plugins\VisualComposer\ActiveComponents;
use Philo\Blade\Blade;

trait BaseComponentController
{
    protected $vcSettings = array();

    protected $class_info = false;
    protected $bladeViewPaths = array();
    protected $bladeCachePath = false;
    protected $bladeView;
    protected $componentBaseName = 'BaseComponentController';

    public function initBaseController($settings)
    {
        $className = str_replace('\\', '/', get_class($this)); // Convert backslash to forwardslash
        $this->componentBaseName = basename($className);
        if (!isset($this->bladeView)) {
            $this->bladeView = str_replace(
                '_',
                '-',
                Inflector::tableize($this->componentBaseName)
            );
        }
        $this->bladeViewPaths[] = get_template_directory() . '/bem-views';
        $this->bladeViewPaths[] = get_template_directory() . '/views';
        $this->bladeViewPaths[] = get_stylesheet_directory() . '/bem-views';
        $this->bladeViewPaths[] = get_stylesheet_directory() . '/views';
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
                'helsingborg-h22/visual-composer/' .
                    $this->bladeView .
                    '/vcSettings',
                $this->vcSettings
            );
            vc_map($this->vcSettings);

            ActiveComponents::getInstance()->addComponent(
                $this->vcSettings['base']
            );
            return true;
        }
        return false;
    }

    /*
     * Returns the class that is considered the root of the component.
     */
    protected function getClassSource()
    {
        return new \ReflectionClass($this);
    }

    protected function setViewPaths()
    {
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

    public function repairString($string)
    {
        $tidy = new \tidy();
      
        return $tidy->repairString($string, array('show-body-only' => true));
    }

    public function output($atts, $content = null, $shortcode_name = '')
    {
        if (!is_array($atts)) {
            $atts = array();
        }
        $data = array_merge($atts, [
            'content' => $this->repairString(wpb_js_remove_wpautop($content)),
            'shortcode_name' => $shortcode_name,
        ]);
        $data = $this->prepareData($data);
        // $atts = $data['atts'] ?? [];
        // $content = $data['content'] ?? null;
        // $shortcode_name = $data['shortcode_name'] ?? '';

        $this->setViewPaths();

        // e.g. helsingborg-h22/visual-composer/card/data
        $data = apply_filters(
            'helsingborg-h22/visual-composer/' . $this->bladeView . '/data',
            $data,
            // $atts,
            // $content,
            // $shortcode_name,
            $this->vcSettings
        );
        $blade = new Blade($this->bladeViewPaths, $this->bladeCachePath);
        return $blade
            ->view()
            ->make($this->bladeView, $data)
            ->render();
    }

    public function prepareData($data)
    {
        return $data;
    }
}
