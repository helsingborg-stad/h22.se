<?php
namespace H22\Plugins\VisualComposer\Components\VCSingleImage;

use H22\Plugins\VisualComposer\Components\BaseComponentController;
use WPBMap;

require_once WP_PLUGIN_DIR .
    '/js_composer/include/classes/shortcodes/vc-single-image.php';

if (
    !class_exists(
        '\H22\Plugins\VisualComposer\Components\VCSingleImage\VCSingleImage'
    )
):
    class VCSingleImage extends \WPBakeryShortCode_VC_Section
    {
        use BaseComponentController;

        public function __construct()
        {
            add_action('vc_after_init', array($this, 'adminJS'));
            add_action('vc_after_init', array($this, 'changeTemplateSource'));
            add_action('vc_after_init', array($this, 'removeParams'));
            add_action('vc_after_init', array($this, 'changeParams'));
            $this->initBaseController(false);
        }

        public function adminJS()
        {
            \WPBMap::modify('vc_single_image', 'js_view', 'ViewVCSingleImageModule');
            \WPBMap::modify(
                'vc_single_image',
                'admin_enqueue_js',
                \H22\Helper\FileSystem::themeUrl(dirname(__FILE__)) .
                    '/js/vc_single_image.js'
            );
        }

        public function changeTemplateSource()
        {
            \WPBMap::modify(
                'vc_single_image',
                'html_template',
                dirname(__FILE__) . '/VCSingleImage.php'
            );
        }

        public function removeParams()
        {
            vc_remove_param('vc_single_image', 'title');
            vc_remove_param('vc_single_image', 'alignment');
            vc_remove_param('vc_single_image', 'onclick');
            vc_remove_param('vc_single_image', 'css_animation');
            vc_remove_param('vc_single_image', 'el_id');
            vc_remove_param('vc_single_image', 'el_class');
            vc_remove_param('vc_single_image', 'css');
            vc_remove_param('vc_single_image', 'style');
            vc_remove_param('vc_single_image', 'external_style');
            vc_remove_param('vc_single_image', 'external_border_color');
            vc_remove_param('vc_single_image', 'border_color');
            vc_remove_param('vc_single_image', 'link');
            vc_remove_param('vc_single_image', 'img_link_target');
        }

        public function changeParams()
        {
            // update image source dropdown list
            $param = WPBMap::getParam('vc_single_image', 'source');
            $param['value'] = [
                __('Media library', 'h22') => 'media_library',
                __('External image', 'h22') => 'external_link',
            ];
            $param['std'] = 'media_library';
            WPBMap::mutateParam('vc_single_image', $param);

            // update external link heading and description
            $param = WPBMap::getParam('vc_single_image', 'custom_src');
            $param['heading'] = 'External image link';
            $param['description'] = 'Enter the link to your external image.';
            WPBMap::mutateParam('vc_single_image', $param);

            //add alt text for external images
            vc_add_param('vc_single_image', [
                'type' => 'textfield',
                'heading' => __('Alt text', 'h22'),
                'param_name' => 'custom_alt',
                'description' => 'Add an alternative text for your image.',
                'value' => '',
                'dependency' => array(
                    'element' => 'source',
                    'value' => array('external_link'),
                ),
            ]);

            // Update image size field with a limited dropdown list
            $param = WPBMap::getParam('vc_single_image', 'img_size');
            $param['type'] = 'dropdown';
            $param['value'] = [
                __('Full width', 'h22') => 'full-width',
                __('Content width', 'h22') => 'content-width',
            ];
            $param['description'] = 'Select the width of your image.';
            $param['std'] = 'full-width';
            WPBMap::mutateParam('vc_single_image', $param);

            $param = WPBMap::getParam('vc_single_image', 'external_img_size');
            $param['type'] = 'dropdown';
            $param['value'] = [
                __('Full width', 'h22') => 'full-width',
                __('Content width', 'h22') => 'content-width',
            ];
            $param['description'] = 'Select the width of your image.';
            $param['std'] = 'full-width';
            WPBMap::mutateParam('vc_single_image', $param);
        }

        public function prepareData($data)
        {
            $data['source'] = $data['source'] ?? 'media_library';

            $single_image = array(
                'attributes' => array(
                    'class' => array(),
                ),
                'caption' => '',
                'size' => '',
            );

            if ($data['source'] == 'media_library') {
                // get image
                $single_image['attributes']['src'] = wp_get_attachment_url(
                    $data['image']
                );
                $single_image['attributes']['srcset'] = wp_get_attachment_image_srcset(
                    $data['image']
                );
                $single_image['attributes']['alt'] = get_post_meta(
                    $data['image'],
                    '_wp_attachment_image_alt',
                    true
                );

                //get caption
                $single_image['caption'] = $data['add_caption']
                    ? wp_get_attachment_caption($data['image'])
                    : null;

                $single_image['size'] = $data['img_size'] ?? 'full-width';
            } else {
                // get image
                $single_image['attributes']['src'] = $data['custom_src'];
                $single_image['attributes']['alt'] = $data['custom_alt'];
                $single_image['caption'] = $data['caption'];
                $single_image['size'] = $data['external_img_size'] ?? 'full-width';
            }

            $single_image['attributes'] = array_filter($single_image['attributes']);
            $single_image = array_filter($single_image);
            $data['single_image'] = $single_image;

            return $data;
        }
    }
endif;

/**
 * From wp-content/plugins/js_composer/include/templates/shortcodes/vc_single_image.php
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
    $element = new VCSingleImage();
    echo $element->output($atts, $content, 'vc_single_image');
endif;
