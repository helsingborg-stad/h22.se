<?php
namespace H22\Plugins\VisualComposer\Components\VcRow;

use H22\Plugins\VisualComposer\Components\BaseComponentController;

if (!class_exists('\H22\Plugins\VisualComposer\Components\VcRow\VcRow')) :
    class VcRow extends \WPBakeryShortCodesContainer
    {
        use BaseComponentController;

        public function __construct()
        {
            add_action('vc_after_init', array($this, 'changeTemplateSource'));
            add_action('vc_after_init', array($this, 'adminJS'));
            add_action('vc_after_init', array($this, 'removeParams'));
            add_action('vc_after_init', array($this, 'addParams'));
            $this->initBaseController(false);
        }

        public function changeTemplateSource()
        {
            \WPBMap::modify(
                'vc_row',
                'html_template',
                dirname(__FILE__) . '/VcRow.php'
            );
        }

        public function adminJS()
        {
            \WPBMap::modify('vc_row', 'js_view', 'ViewVCRowModule');
            \WPBMap::modify(
                'vc_row',
                'admin_enqueue_js',
                \H22\Helper\FileSystem::themeUrl(dirname(__FILE__)) .
                    '/js/vc_row.js'
            );
        }

        public function removeParams()
        {
            vc_remove_param('vc_row', 'gap');
            vc_remove_param('vc_row', 'video_bg');
            vc_remove_param('vc_row', 'video_bg_url');
            vc_remove_param('vc_row', 'video_bg_parallax');
            vc_remove_param('vc_row', 'parallax');
            vc_remove_param('vc_row', 'parallax_image');
            vc_remove_param('vc_row', 'parallax_speed_video');
            vc_remove_param('vc_row', 'parallax_speed_bg');
            vc_remove_param('vc_row', 'css_animation');
            vc_remove_param('vc_row', 'disable_element');
            vc_remove_param('vc_row', 'rtl_reverse');
            vc_remove_param('vc_row', 'full_width');
            vc_remove_param('vc_row', 'full_height');
            vc_remove_param('vc_row', 'equal_height');
            vc_remove_param('vc_row', 'content_placement');
            vc_remove_param('vc_row', 'columns_placement');
        }

        public function addParams()
        {
            vc_add_param('vc_row', [
                'type' => 'dropdown',
                'heading' => __('Container width', 'h22'),
                'param_name' => 'container',
                'value' => array(
                    __('Default', 'h22') => '',
                    __('Content', 'h22') => 'content',
                    __('Small', 'h22') => 'small',
                    __('Wide', 'h22') => 'wide',
                    __('Full width', 'h22') => 'full-width',
                ),
                'weight' => 100
            ]);

            vc_add_param('vc_row', [
                'type' => 'dropdown',
                'heading' => __('Column gutter', 'h22'),
                'param_name' => 'column_gutter',
                'value' => array(
                    __('Default', 'h22') => '',
                    __('No gutter', 'h22') => 'no-gutter',
                    __('Small', 'h22') => 'small',
                    __('Tiles Grid', 'h22') => 'tiles',
                ),
                'weight' => 100
            ]);

            vc_add_param('vc_row', [
                'type' => 'dropdown',
                'heading' => __('Column alignment (vertical)', 'h22'),
                'param_name' => 'column_va',
                'value' => array(
                    __('Stretch (default)', 'h22') => '',
                    __('Top', 'h22') => 'start',
                    __('Middle', 'h22') => 'center',
                    __('Bottom', 'h22') => 'end',
                ),
                'weight' => 100
            ]);

            vc_add_param('vc_row', [
                'type' => 'dropdown',
                'heading' => __('Reverse column order', 'h22'),
                'param_name' => 'column_reverse',
                'value' => array(
                    __('Disabled (default)', 'h22') => '',
                    __('SM', 'h22') => 'sm',
                    __('MD', 'h22') => 'md',
                    __('LG', 'h22') => 'lg',
                ),
                'weight' => 100
            ]);

            vc_add_param('vc_row', [
                'type' => 'textfield',
                'heading' => __('Extra class names - container', 'h22'),
                'param_name' => 'container_class',
                'value' => '',
                'group' => '',
                'weight' => 0
            ]);
        }

        protected function getRowClasses($data)
        {
            $classes = [
                'grid', // Municipio styleguide,
            ];

            if (isset($data['el_class'])) {
                $classes = array_merge($classes, [$data['el_class']]);
            }

            if (isset($data['column_gutter']) && !empty($data['column_gutter'])) {
                $gridGutterClasses = array(
                    'no-gutter' => 'grid--no-gutter',
                    'small' => 'grid--small',
                    'tiles' => 's-tiles-grid'
                );
                $classes[] = isset($gridGutterClasses[$data['column_gutter']]) ? $gridGutterClasses[$data['column_gutter']] : '';
            }

            if (isset($data['column_va']) && !empty($data['column_va'])) {
                $classes[] = 'u-align-items-' . $data['column_va'];
            }

            if (isset($data['column_reverse']) && !empty($data['column_reverse'])) {
                $classes[] = 'grid-' . $data['column_reverse'] . '-row-reverse ';
            }

            return array_unique($classes);
        }

        protected function getContainerClasses($data)
        {
            $classes = [
                'container',
            ];


            if (isset($data['container_class'])) {
                $classes = array_merge($classes, [ $data['container_class']]);
            }

            $classes[] = isset($data['container']) && !empty($data['container']) ? 'container--' . $data['container'] : '';

            if (isset($data['container_class']) && !empty($data['container_class'])) {
                $classes[] = $data['container_class'];
            }

            if (in_array('grid--no-gutter', $data['attributes']['class'])
                && in_array('container--full-width', $classes)
                || in_array('grid--no-gutter', $data['attributes']['class'])
                && in_array('container--full-width', $classes)) {
                $classes[] = 'container--no-gutter';
            }

            return array_unique($classes);
        }

        public function prepareData($data)
        {
            $data['attributes']['class'] = $this->getRowClasses($data);
            $data['containerAttributes']['class'] = $this->getContainerClasses($data);

            return $data;
        }
    }
endif;

/**
 * From wp-content/plugins/js_composer/include/templates/shortcodes/vc_row.php
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $equal_height
 * @var $columns_placement
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $parallax_speed_bg
 * @var $parallax_speed_video
 * @var $content - shortcode content
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */
if (isset($atts)):
    $row = new VcRow();
    echo $row->output($atts, $content, 'vc_row');
endif;
