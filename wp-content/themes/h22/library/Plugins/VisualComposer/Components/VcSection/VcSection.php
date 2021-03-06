<?php

namespace H22\Plugins\VisualComposer\Components\VcSection;

use H22\Plugins\VisualComposer\Components\BaseComponentController;
use H22\Plugins\VisualComposer\Components\GeneralComponentParams;

require_once WP_PLUGIN_DIR .
    '/js_composer/include/classes/shortcodes/vc-section.php';

if (
    !class_exists('\H22\Plugins\VisualComposer\Components\VcSection\VcSection')
) :
    class VcSection extends \WPBakeryShortCode_VC_Section
    {
        use BaseComponentController;
        use GeneralComponentParams;

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
                'vc_section',
                'html_template',
                dirname(__FILE__) . '/VcSection.php'
            );
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
            $this->generalThemeParams('vc_section');
            $this->generalTextColorParams('vc_section');
            $this->generalBackgroundParams('vc_section');

            vc_add_param('vc_section', [
                'param_name' => 'min_height',
                'type' => 'dropdown',
                'heading' => __('Minimum height', 'h22'),
                'value' => array(
                    __('None', 'h22') => '',
                    __('Small', 'h22') => 'sm',
                    __('Medium', 'h22') => 'md',
                    __('Large', 'h22') => 'lg',
                    __('100% of Viewport', 'h22') => '100vh',
                    __('90% of Viewport', 'h22') => '90vh',
                    __('80% of Viewport', 'h22') => '80vh',
                    __('70% of Viewport', 'h22') => '70vh',
                    __('60% of Viewport', 'h22') => '60vh',
                ),
                'weight' => 80
            ]);

            vc_add_param('vc_section', [
                'param_name' => 'content_alignment',
                'type' => 'dropdown',
                'heading' => __('Content alignment (vertical)', 'h22'),
                'value' => array(
                    __('Top (default)', 'h22') => '',
                    __('Middle', 'h22') => 'center',
                    __('Bottom', 'h22') => 'end',
                ),
                'weight' => 80
            ]);

            vc_add_param('vc_section', [
                'param_name' => 'background_video',
                'type' => 'attach_image',
                'heading' => __('Background video', 'h22'),
                'value' => '',
                'group' => 'Background'
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
        }

        public function prepareData($data)
        {
            $data['attributes']['class'][] = 'c-section c-section--subtract-bot';
            $data['attributes']['class'][] = isset($data['min_height']) && !empty($data['min_height']) ? "c-section--min-height-{$data['min_height']}" : '';
            $data['attributes']['class'][] = !empty($data['el_class']) ? $data['el_class'] : '';

            // Color Theme
            if (isset($data['color_theme']) && !empty($data['color_theme'])) {
                $data['attributes']['class'][] = 't-' . $data['color_theme'];

                if (strpos($data['color_theme'], 'fill') !== false) {
                    $data['attributes']['class'][] = 'has-fill';
                }
            }

            // Text Color
            if (isset($data['text_color']) && !empty($data['text_color'])) {
                if ($data['text_color'] === 'custom') {
                    $data['attributes']['style']['color'] = $data['text_color_hex'] ?? '';
                } else {
                    $data['attributes']['class'][] = 'u-text-' . $data['text_color'];
                }
            }

            // Background Color
            if (isset($data['bg_color']) && !empty($data['bg_color'])) {
                if ($data['bg_color'] === 'custom') {
                    $data['attributes']['style']['background-color'] = $data['bg_color_hex'] ?? '';
                } else {
                    $data['attributes']['class'][] = 'u-bg-' . $data['bg_color'];
                }

                if (!in_array('has-fill', $data['attributes']['class'])) {
                    $data['attributes']['class'][] = 'has-fill';
                }
            }

            // Featured Image as Background Image Source
            if (isset($data['bg_image_src']) && $data['bg_image_src'] === 'featured_image') {
                $data['bg_image'] = get_post_thumbnail_id(get_queried_object_id());
                $data['bg_image'] = apply_filters('H22/Plugins/VisualComposer/Components/VcSection/bgImage', $data['bg_image']);
            }

            // Background image
            if (isset($data['bg_image']) && !empty($data['bg_image'])) {
                $data['attributes']['style']['background-image'] = "url('" . wp_get_attachment_url($data['bg_image']) . "')";
                $data['attributes']['style']['background-repeat'] = $data['bg_repeat'] ?? '';
                $data['attributes']['style']['background-size'] = $data['bg_size'] ?? '';
                $data['attributes']['style']['background-size'] = $data['bg_size_custom'] ?? $data['attributes']['style']['background-size'];
                $data['attributes']['style']['background-position'] = $data['bg_pos'] ?? '';
                $data['attributes']['style']['background-position'] = $data['bg_pos_custom'] ?? $data['attributes']['style']['background-position'];

                if (!in_array('has-fill', $data['attributes']['class'])) {
                    $data['attributes']['class'][] = 'has-fill';
                }
            }

            // Content Alignment
            if (isset($data['content_alignment']) && !empty($data['content_alignment'])) {
                $data['attributes']['class'][] = 'u-justify-content-' . $data['content_alignment'];
            }

            // Overlay
            if (isset($data['overlay']) && !empty($data['overlay'])) {
                $data['attributes']['class'][] = 'o-overlay-' . $data['overlay'];
            }

            if (isset($data['no_space_el']) && $data['no_space_el'] === 'true') {
                $data['attributes']['class'][] = 's-elements-mb-0';
            }

            if (isset($data['el_id'])) {
                $data['attributes']['id'] = $data['el_id'];
            }

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
                    'type' => 'video/' . $background_video['fileformat'],
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
if (isset($atts)) :
    $element = new VcSection();
    echo $element->output($atts, $content, 'vc_section');
endif;
