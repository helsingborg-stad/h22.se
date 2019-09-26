<?php

namespace H22;

class App
{
    public function __construct()
    {
        add_action('admin_init', array($this, 'requireDependencies'));
        add_filter('Municipio/Helper/Styleguide/_getTheme/triggerColorSchemeError', function () {
            return false;
        });

        add_filter('acf/settings/remove_wp_meta_box', function ($bool) {
            $allowedPostTypes = array('shop_order', 'product', 'pb-template', 'event_magic_tickets');
            if (!empty(get_post_type()) && in_array(get_post_type(), $allowedPostTypes)) {
                return false;
            }

            return true;
        }, 999);


        new \H22\Admin\Municipio\DisableACFFields();
        new \H22\Controller\ChildController();
        new \H22\Theme\Enqueue();
        new \H22\Theme\Color();
        new \H22\Theme\CustomPostTypes();
        new \H22\Theme\CustomTaxonomies();
        new \H22\Theme\Archive();
        new \H22\Theme\Sidebars();
        new \H22\Theme\Navigation();
        new \H22\Content\Excerpt();
        new \H22\Plugins\VisualComposer\Main();
        new \H22\Plugins\Woocommerce\Cart();
        new \H22\Plugins\Woocommerce\VisualComposer();
        new \H22\Plugins\Woocommerce\Email();
        new \H22\Plugins\Woocommerce\FooEvents();
        new \H22\Widget\Widgets();
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
