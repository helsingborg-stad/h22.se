<?php
namespace H22\Plugins\VisualComposer\Components\VCSection;

use H22\Plugins\VisualComposer\Components\BaseComponentController;

require_once WP_PLUGIN_DIR .
    '/js_composer/include/classes/shortcodes/vc-section.php';

if (
    !class_exists('\H22\Plugins\VisualComposer\Components\VCSection\VCSection')
):
    class VCSection extends \WPBakeryShortCode_VC_Section
    {
        use BaseComponentController;

        public function __construct()
        {
            add_action('vc_after_init', array($this, 'adminJS'));
            add_action('vc_after_init', array($this, 'changeTemplateSource'));
            add_action('vc_after_init', array($this, 'removeParams'));
            add_action('vc_after_init', array($this, 'addParams'));
            $this->initBaseController(false);
        }

        public function adminJS()
        {
            \WPBMap::modify('vc_section', 'js_view', 'ViewVCSectionModule');
            \WPBMap::modify(
                'vc_section',
                'admin_enqueue_js',
                \H22\Helper\FileSystem::themeUrl(dirname(__FILE__)) .
                    '/js/vc_section.js'
            );
        }

        public function changeTemplateSource()
        {
            \WPBMap::modify(
                'vc_section',
                'html_template',
                dirname(__FILE__) . '/VCSection.php'
            );
        }

        public function removeParams()
        {
            vc_remove_param('vc_section', 'content_placement');
            vc_remove_param('vc_section', 'css_animation');
            vc_remove_param('vc_section', 'css');
            vc_remove_param('vc_section', 'full_height');
            vc_remove_param('vc_section', 'full_width');
            vc_remove_param('vc_section', 'parallax_image');
            vc_remove_param('vc_section', 'parallax_speed_bg');
            vc_remove_param('vc_section', 'parallax_speed_video');
            vc_remove_param('vc_section', 'parallax');
            vc_remove_param('vc_section', 'video_bg_parallax');
            vc_remove_param('vc_section', 'video_bg_url');
            vc_remove_param('vc_section', 'video_bg');
        }

        public function addParams()
        {
            vc_add_param('vc_section', [
                'param_name' => 'min_height',
                'type' => 'dropdown',
                'heading' => __('Minimum height', 'h22'),
                'value' => array(
                    __('None', 'h22') => '',
                    __('Small', 'h22') => 'sm',
                    __('Medium', 'h22') => 'md',
                    __('Large', 'h22') => 'lg',
                ),
                'std' => '',
            ]);
            vc_add_param('vc_section', [
                'param_name' => 'color_theme',
                'type' => 'dropdown',
                'heading' => __('Color theme', 'h22'),
                'value' => array(
                    // __('Default', 'h22') => '',
                    __('Red text', 'h22') => 'red',
                    __('Green text', 'h22') => 'green',
                    __('Blue text', 'h22') => 'blue',
                    __('Purple text', 'h22') => 'purple',
                    __('Red background', 'h22') => 'bg-red',
                    __('Green background', 'h22') => 'bg-green',
                    __('Blue background', 'h22') => 'bg-blue',
                    __('Purple background', 'h22') => 'bg-purple',
                ),
                'std' => 'blue',
            ]);
            vc_add_param('vc_section', [
                'param_name' => 'background_video',
                'type' => 'attach_image',
                'heading' => __('Background video', 'h22'),
                'value' => '',
            ]);
            vc_add_param('vc_section', [
                'param_name' => 'background_video_fallback',
                'type' => 'attach_image',
                'heading' => __('Fallback image', 'h22'),
                'description' => __(
                    'This image is shown while the video is loading.',
                    'h22'
                ),
                'value' => '',
                'dependency' => array(
                    'element' => 'background_video',
                    'not_empty' => true,
                ),
            ]);
            vc_add_param('vc_section', [
                'param_name' => 'overlay',
                'type' => 'checkbox',
                'heading' => __('Background overlay', 'h22'),
                'description' => __(
                    'If checked an overlay will be added on the background to increase contrast',
                    'h22'
                ),
                'value' => array(
                    __('Yes', 'h22') => 'yes',
                ),
                'dependency' => array(
                    'element' => 'background_video',
                    'not_empty' => true,
                ),
            ]);
        }

        public function prepareData($data)
        {
            $data['attributes']['class'][] = 'c-section';

            if (!empty($data['min_height'])) {
                $data['attributes'][
                    'class'
                ][] = "c-section--min-height-{$data['min_height']}";
            }

            $color_theme = $data['color_theme'] ?? 'blue';
            $data['attributes']['class'][
                'color_theme'
            ] = "c-section--color-theme-{$color_theme}";

            if (isset($data['background_video'])) {
                $background_video = wp_get_attachment_metadata(
                    $data['background_video']
                );

                $video_attributes['class'][] = 'c-section__bg-video';
                $video_attributes['autoplay'] = true;
                $video_attributes['loop'] = true;
                $video_attributes['muted'] = true;

                $video_sources[] = [
                    'src' => wp_get_attachment_url($data['background_video']),
                    'type' => $background_video['mime_type'],
                ];

                if (isset($data['background_video_fallback'])) {
                    $video_attributes['poster'] = wp_get_attachment_url(
                        $data['background_video_fallback']
                    );
                }

                $data['background_video'] = $background_video;
                $data['background_video']['attributes'] = $video_attributes;
                $data['background_video']['sources'] = $video_sources;
                $data['attributes']['class'][] = 'c-section--with-background';
                unset($data['attributes']['class']['color_theme']);
            }

            if (!empty($data['overlay'])) {
                $data['attributes']['class'][] = 'c-section--with-overlay';
            }

            return $data;
        }
    }
endif;

/**
 * From wp-content/plugins/js_composer/include/templates/shortcodes/vc_section.php
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
    $element = new VCSection();
    echo $element->output($atts, $content, 'vc_section');
endif;
