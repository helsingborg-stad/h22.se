<?php

namespace H22\Plugins\VisualComposer;

class Main
{
    public function __construct()
    {
        if (!class_exists('Vc_Manager')) {
            return;
        }
        new RemoveElements();
        new PageBuilderTemplate();
        new PageBuilderTemplateType();

        add_action('vc_after_init', array($this, 'customParamTypes'), 1000);
        add_action('vc_before_init', array($this, 'hideDesignOptionsAndCustomCss'));
        add_filter('vc_before_init', array($this, 'disableFrontend'), 1);
        add_filter('vc_before_init', array($this, 'initCustomComponents'), 99);
    }

    public function customParamTypes()
    {
        new ParamTypes\VcColumnOffset();
    }
    
    public function hideDesignOptionsAndCustomCss()
    {
        vc_set_as_theme();
    }

    public function disableFrontend()
    {
        vc_disable_frontend();
    }

    /*
        Init all registered VC Components
    */
    public function initCustomComponents()
    {
        $components = $this->_initComponents();
        $components = apply_filters(
            'helsingborg-h22/visual-composer/register-components',
            $components
        );
        foreach ($components as $path => $component) {
            if (
                isset($component['componentName']) &&
                isset($component['namespace'])
            ) {
                require_once $path . '/' . $component['componentName'] . '.php';
                $class = $component['namespace'];
                $class = apply_filters(
                    'helsingborg-h22/visual-composer/init-class-component/' .
                        strtolower($component['componentName']),
                    $class,
                    $component,
                    $path
                );
                new $class();
            }
        }
    }

    /*
        Scan local VC Components
    */
    private function _initComponents()
    {
        $componentsFolder = 'Components';
        $directory = dirname(__FILE__) . '/' . $componentsFolder;
        $components = array();
        foreach (@glob($directory . '/*', GLOB_ONLYDIR) as $folder) {
            $componentName = basename($folder);
            $components[$folder] = array(
                'componentName' => $componentName,
                'namespace' =>
                    '\H22\Plugins\VisualComposer\\' .
                    $componentsFolder .
                    '\\' .
                    $componentName .
                    '\\' .
                    $componentName,
            );
        }
        return $components;
    }
}
