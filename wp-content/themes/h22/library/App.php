<?php
namespace H22;

class App
{
    public function __construct()
    {
        add_action('admin_init', array($this, 'requireDependencies'));

        new \H22\Admin\Municipio\DisableACFFields();
        new \H22\Controller\ChildController();
        new \H22\Theme\Enqueue();
        new \H22\Theme\Color();
        new \H22\Theme\CustomPostTypes();
        new \H22\Plugins\VisualComposer\Main();
    }

    public function requireDependencies()
    {
        if (!is_plugin_active('js_composer/js_composer.php')) {
            add_action('admin_notices', function () {
                echo '<div class="notice notice-error"><p>To run <strong>Helsingborg H22</strong> theme, please install & activate the "Visual Composer Page Builder - WP Bakery" plugin.</p></div>';
            });
        }
    }
}
