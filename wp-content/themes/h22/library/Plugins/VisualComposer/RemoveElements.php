<?php

namespace H22\Plugins\VisualComposer;

use H22\Plugins\VisualComposer\ActiveComponents as ActiveComponents;

class RemoveElements
{
    public function __construct()
    {
        add_action(
            'vc_after_init',
            array($this, 'allThemeRegisteredVcModules'),
            100
        );
    }

    public function allThemeRegisteredVcModules()
    {
        $filteredAllowedComponents = ActiveComponents::getInstance()->getAllowedComponents(
            array(
                'vc_column_inner',
                'vc_column_text',
                'vc_column',
                'vc_row_inner',
                'vc_row',
                'vc_section',
                'vc_single_image',
                // 'vc_basic_grid',
                // 'vc_images_carousel',
                // 'vc_tta_section',
                // 'vc_tta_tabs',
                // 'vc_video',
            )
        );

        $shortcodes = \WPBMap::getAllShortCodes();
        if ($shortcodes && is_array($shortcodes)) {
            foreach ($shortcodes as $index => $shortcode) {
                if (!in_array($shortcode['base'], $filteredAllowedComponents)) {
                    vc_remove_element($shortcode['base']);
                }
            }
        }
    }
}
