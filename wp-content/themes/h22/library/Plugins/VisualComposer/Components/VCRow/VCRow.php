<?php
namespace H22\Plugins\VisualComposer\Components\VCRow;

use H22\Plugins\VisualComposer\Components\BaseComponentController;

if (!class_exists('\H22\Plugins\VisualComposer\Components\VCRow\VCRow')):
    class VCRow extends \WPBakeryShortCodesContainer
    {
        use BaseComponentController;

        public function __construct()
        {
            add_action('vc_after_init', array($this, 'adminJS'));
            add_action('vc_after_init', array($this, 'changeTemplateSource'));
            add_action('vc_after_init', array($this, 'removeUnwantedParams'));
            add_action('vc_after_init', array($this, 'responsiveColumns'));
            $this->initBaseController(false);
        }

        public function adminJS()
        {
            \WPBMap::modify('vc_row', 'js_view', 'ViewVCRowModule');
            \WPBMap::modify(
                'vc_row',
                'admin_enqueue_js',
                \H22\Helper\FileSystem::themeUrl(dirname(__FILE__)) . '/js/vc_row.js'
            );
        }

        public function changeTemplateSource()
        {
            \WPBMap::modify(
                'vc_row',
                'html_template',
                dirname(__FILE__) . '/VCRow.php'
            );
        }

        public function removeUnwantedParams()
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
        }

        public function responsiveColumns()
        {
            vc_add_param('vc_row', array(
                'type' => 'checkbox',
                'heading' => __(
                    'Invert columns in mobile and tablet breakpoints?',
                    'h22'
                ),
                'description' => __(
                    'This setting is useful when you i.e. create multiple rows where images and texts are alternated. In smaller screens this would cause the elements to display in an order that is hard to follow.',
                    'h22'
                ),
                'param_name' => 'mobile_invert_cols',
                'value' => array(__('Yes', 'js_composer') => 'yes'),
                'group' => __('Responsive', 'h22'),
            ));
            vc_add_param('vc_row', array(
                'type' => 'dropdown',
                'heading' => __(
                    'At which breakpoint should the inversion start',
                    'trivec'
                ),
                'description' => __(
                    'The default behaviour is to invert at Medium breakpoint',
                    'h22'
                ),
                'param_name' => 'mobile_invert_cols_breakpoint',
                'value' => array(
                    __('Small', 'h22') => 'xs,sm',
                    __('Medium', 'h22') => 'xs,sm,md',
                    __('Large', 'h22') => 'xs,sm,md,lg',
                ),
                'dependency' => array(
                    'element' => 'mobile_invert_cols',
                    'not_empty' => true,
                ),
                // Sets default value
                'std' => 'xs,sm,md',
                'group' => __('Responsive', 'h22'),
            ));
        }

        protected function getCssClasses($data)
        {
            $classes = [
                'grid', // Municipio styleguide
                $this->getExtraClass($data['el_class']),
            ];

            if (!empty($data['mobile_invert_cols'])) {
                $mobile_invert_cols_breakpoint = explode(
                    ',',
                    $data['mobile_invert_cols_breakpoint'] ?: 'xs,sm,md'
                );
                foreach ($mobile_invert_cols_breakpoint as $breakpoint) {
                    switch ($breakpoint) {
                        case 'xs':
                        case 'sm':
                            $classes[] = sprintf('u-flex-column-reverse@%s', $breakpoint);
                            break;
                        case 'md':
                        case 'md':
                        default:
                            $classes[] = sprintf('u-flex-row-reverse@%s', $breakpoint);
                            break;
                    }
                }
            }
            // Todo: replace with HBG styleguide matching class
            if (!empty($data['full_width'])) {
                $classes[] = 'vc_row-no-padding';
            }

            // Todo: replace with HBG styleguide matching class
            if (!empty($data['full_height'])) {
                $classes[] = 'vc_row-o-full-height';
                if (!empty($data['columns_placement'])) {
                    $classes[] = 'vc_row-o-columns-' . $data['columns_placement'];
                    if ('stretch' === $data['columns_placement']) {
                        $classes[] = 'vc_row-o-equal-height';
                    }
                }
            }

            // Todo: replace with HBG styleguide matching class
            if (!empty($data['equal_height'])) {
                $classes[] = 'vc_row-o-equal-height';
            }

            // Todo: replace with HBG styleguide matching class
            if (!empty($data['content_placement'])) {
                $classes[] = 'vc_row-o-content-' . $data['content_placement'];
            }

            return array_unique($classes);
        }

        public function prepareData($data)
        {
            $data['attributes']['class'] = $this->getCssClasses($data);
            $data['attributes']['class'] = apply_filters(
                'helsingborg-h22/visual-composer/VCRow/html_class',
                $data['attributes']['class'],
                'vc_row',
                $data
            );
            // $afterOutput = '';
            // Todo: replace with HBG styleguide matching class
            if (!empty($data['full_width'])) {
                $data['attributes'][] = 'data-vc-full-width="true"';
                $data['attributes'][] = 'data-vc-full-width-init="false"';
                if ('stretch_row_content' === $data['full_width']) {
                    $data['attributes'][] = 'data-vc-stretch-content="true"';
                } elseif ('stretch_row_content_no_spaces' === $data['full_width']) {
                    $data['attributes'][] = 'data-vc-stretch-content="true"';
                    $data['attributes']['class'][] = 'vc_row-no-padding';
                }
                // $afterOutput .= '<div class="vc_row-full-width vc_clearfix"></div>';
            }
            // $data['afterOutput'] = $afterOutput;

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
    $row = new VCRow();
    echo $row->output($atts, $content, 'vc_row');
endif;
