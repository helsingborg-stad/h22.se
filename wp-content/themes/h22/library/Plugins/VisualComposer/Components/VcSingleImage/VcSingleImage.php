<?php
namespace H22\Plugins\VisualComposer\Components\VcSingleImage;

use H22\Plugins\VisualComposer\Components\BaseComponentController;
use WPBMap;

if (
    !class_exists(
        '\H22\Plugins\VisualComposer\Components\VcSingleImage\VcSingleImage'
    )
):
    class VcSingleImage extends \WPBakeryShortCode
    {
        use BaseComponentController;

        public function __construct()
        {
            add_action('vc_after_init', array($this, 'changeTemplateSource'));
            add_action('vc_after_init', array($this, 'removeParams'));
            add_action('vc_after_init', array($this, 'addAndModifyParams'));

            $this->initBaseController(false);
        }

        public function adminJS()
        {
            \WPBMap::modify(
                'vc_single_image',
                'js_view',
                'ViewVCSingleImageModule'
            );
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
                dirname(__FILE__) . '/VcSingleImage.php'
            );
        }

        public function removeParams()
        {
            vc_remove_param('vc_single_image', 'title');
            vc_remove_param('vc_single_image', 'alignment');
            vc_remove_param('vc_single_image', 'onclick');
            vc_remove_param('vc_single_image', 'css_animation');
            vc_remove_param('vc_single_image', 'el_id');
            // vc_remove_param('vc_single_image', 'el_class');
            vc_remove_param('vc_single_image', 'css');
            vc_remove_param('vc_single_image', 'style');
            vc_remove_param('vc_single_image', 'external_style');
            vc_remove_param('vc_single_image', 'external_border_color');
            vc_remove_param('vc_single_image', 'border_color');
            vc_remove_param('vc_single_image', 'link');
            vc_remove_param('vc_single_image', 'img_link_target');
        }

        public function addAndModifyParams()
        {
            // update image source dropdown list
            $param = WPBMap::getParam('vc_single_image', 'source');
            $param['value'] = [
                __('Media library', 'h22') => 'media_library',
                __('External image', 'h22') => 'external_link',
                __('Featured image', 'h22') => 'featured_image',
            ];
            $param['weight'] = 20;
            $param['std'] = 'media_library';
            WPBMap::mutateParam('vc_single_image', $param);

            // update external link heading and description
            $param = WPBMap::getParam('vc_single_image', 'custom_src');
            $param['heading'] = 'External image link';
            $param['description'] = 'Enter the link to your external image.';
            $param['weight'] = 10;
            WPBMap::mutateParam('vc_single_image', $param);

            //add alt text for external images
            vc_add_param('vc_single_image', [
                'type' => 'textfield',
                'heading' => __('Alt text', 'h22'),
                'param_name' => 'custom_alt',
                'description' => __('Add an alternative text for your image.', 'h22'),
                'value' => '',
                'dependency' => array(
                    'element' => 'source',
                    'value' => array('external_link'),
                ),
                'weight' => 10
            ]);
    
            $param = WPBMap::getParam('vc_single_image', 'caption');
            $param['weight'] = 10;
            WPBMap::mutateParam('vc_single_image', $param);

            $param = WPBMap::getParam('vc_single_image', 'image');
            $param['weight'] = 5;
            WPBMap::mutateParam('vc_single_image', $param);

            // Update image size field with a limited dropdown list
            $param = WPBMap::getParam('vc_single_image', 'img_size');
            $param['type'] = 'dropdown';
            $param['value'] = [
                __('Original size', 'h22') => '',
                __('XXL (1920px)', 'h22') => '1920',
                __('XL (1260px)', 'h22') => '1260',
                __('Large (720px)', 'h22') => '720',
                __('Medium (360px)', 'h22') => '360',
                __('Small (180px)', 'h22') => '180',
                __('Custom width', 'h22') => 'width',
                __('Custom width & height', 'h22') => 'custom',
            ];
            $param['weight'] = 5;
            $param['description'] = 'Select the width of your image.';
            WPBMap::mutateParam('vc_single_image', $param);

            vc_add_param('vc_single_image', [
                'type' => 'textfield',
                'heading' => __('Image width', 'h22'),
                'param_name' => 'img_width',
                'value' => '',
                'dependency' => array(
                    'element' => 'img_size',
                    'value' => array('width', 'custom'),
                ),
                'weight' => 5
            ]);

            vc_add_param('vc_single_image', [
                'type' => 'textfield',
                'heading' => __('Image height', 'h22'),
                'param_name' => 'img_height',
                'value' => '',
                'dependency' => array(
                    'element' => 'img_size',
                    'value' => array('custom'),
                ),
                'weight' => 5
            ]);

            vc_add_param('vc_single_image', [
                'type' => 'dropdown',
                'heading' => __('Image size ratio', 'h22'),
                'param_name' => 'img_size_ratio',
                'value' => array(
                    'Default' => '',
                    '1:1' => '1:1',
                    '4:3' => '4:3',
                    '3:2' => '3:2',
                    '16:9' => '16:9',
                ),
                'dependency' => array(
                    'element' => 'img_size',
                    'value' => array('', '1920', '1260', '720', '360', '180', 'width'),
                ),
                'weight' => 5
            ]);

            vc_add_param('vc_single_image', [
                'type' => 'textfield',
                'heading' => __('Image height', 'h22'),
                'param_name' => 'img_height',
                'value' => '',
                'dependency' => array(
                    'element' => 'img_size',
                    'value' => array('custom'),
                ),
                'weight' => 5
            ]);

            vc_add_param('vc_single_image', [
                'type' => 'dropdown',
                'heading' => __('Image behaviour', 'h22'),
                'param_name' => 'img_behaviour',
                'value' => array(
                    'Default' => '',
                    'Stretch to container width' => 'stretch',
                    'Fit to container' => 'fit',
                    'Fit to ratio' => 'fit-ratio',
                ),
                'weight' => 3,
                'group' => 'Image options'
            ]);

            vc_add_param('vc_single_image', [
                'type' => 'dropdown',
                'heading' => __('Image fit ratio', 'h22'),
                'param_name' => 'img_fit_ratio',
                'value' => array(
                    'Select ratio' => '',
                    '1:1' => '1:1',
                    '4:3' => '4:3',
                    '3:2' => '3:2',
                    '16:9' => '16:9',
                ),
                'dependency' => array(
                    'element' => 'img_behaviour',
                    'value' => array('fit-ratio', 'fit'),
                ),
                'weight' => 3,
                'group' => 'Image options',
                'std' => array('1:1')
            ]);

            vc_add_param('vc_single_image', [
                'type' => 'vc_link',
                'heading' => __('Image link', 'h22'),
                'param_name' => 'img_link',
                'value' => array(),
                'weight' => 2,
                'group' => 'Image options'
            ]);

            $param = WPBMap::getParam('vc_single_image', 'external_img_size');
            $param['type'] = 'dropdown';
            $param['value'] = [
                __('Full width', 'h22') => 'full-width',
                __('Content width', 'h22') => 'content-width',
            ];
            $param['description'] = 'Select the width of your image.';
            $param['std'] = 'full-width';
            WPBMap::mutateParam('vc_single_image', $param);

            $param = WPBMap::getParam('vc_single_image', 'el_class');
            $param['group'] = 'Settings';
            WPBMap::mutateParam('vc_single_image', $param);
        }

        public function prepareData($data)
        {
            $data['source'] = $data['source'] ?? 'media_library';

            $data['attributes'] = array(
                'class' => ['c-single-image']
            );

            $data['attributes']['class'][] = !empty($data['el_class']) ? $data['el_class'] : '';
            $data['attributes']['class'][] = !empty($data['img_behaviour']) ? 'c-single-image--' . $data['img_behaviour'] : '';

            if (!empty($data['img_behaviour']) && in_array($data['img_behaviour'], ['fit', 'fit-ratio'])) {
                $data['attributes']['class'][] = !empty($data['img_fit_ratio']) ? 'u-ratio-' . str_replace(':', '-', $data['img_fit_ratio']) : '';
            }

            $data['single_image'] = $this->getImage($data);

            if (!empty($data['img_link'])) {
                $link = vc_build_link($data['img_link']);
                $link['href'] = $link['url'];
                unset($link['url']);
                $data['linkAttributes'] = $link;
                $data['linkAttributes']['class'] = array('c-single-image__link');
                $data['attributes']['class'][] = 'c-single-image--linked';
            }
            
            $data['noMargin'] = !empty($data['img_behaviour']) && $data['img_behaviour'] === 'fit' ? true : false;

            return $data;
        }

        public function getImage($data)
        {
            $single_image = array(
                'attributes' => array(
                    'class' => array('c-single-image__image'),
                ),
                'caption' => '',
                'size' => '',
            );

            if ($data['source'] !== 'external_link' && $attachment = $this->getAttachment($data)) {
                $single_image['attributes']['src'] = $attachment['url'];
                $single_image['attributes']['srcset'] = wp_get_attachment_image_srcset($attachment['id'], array($attachment['width'], $attachment['height']));
                
                if (!empty($attachment['alt'])) {
                    $single_image['attributes']['alt'] = $attachment['alt'];
                }

                //get caption
                $single_image['caption'] = $data['add_caption']
                    ? $attachment['caption']
                    : null;
            } else {
                // get image
                $single_image['attributes']['src'] = $data['custom_src'];
                $single_image['attributes']['alt'] = $data['custom_alt'];
                $single_image['caption'] = $data['caption'];
                $single_image['size'] =
                $data['external_img_size'] ?? 'full-width';
            }

            return array_filter($single_image);
        }

        public function getAttachment($data)
        {
            $attachmentId = $data['source'] === 'featured_image'
            && get_post_thumbnail_id(get_queried_object_id())
            ? get_post_thumbnail_id(get_queried_object_id()) : false;

    
            if (!$attachmentId && empty($data['image']) || !$attachmentId && !empty($data['image']) && get_post_type($data['image']) !== 'attachment') {
                return false;
            }

            $attachmentId = $attachmentId ? $attachmentId : $data['image'];
            $attachment = array(
                'title' => get_the_title($attachmentId),
                'id' => $attachmentId,
                'mime' => get_post_mime_type($attachmentId),
                'alt' => get_post_meta($attachmentId, '_wp_attachment_image_alt', true),
                'caption' => wp_get_attachment_caption($attachmentId),
            );

            $original['src'] = wp_get_attachment_image_src($attachmentId, 'full');
            $original['url'] = $original['src'][0];
            $original['width'] = $original['src'][1];
            $original['height'] = $original['src'][2];


            if (empty($original['width']) || empty($original['height'])) {
                return array_merge($attachment, array('url' => $original['src']));
            }

            if (!empty($data['img_size']) && is_numeric($data['img_size'])) {
                $resized['width'] = $data['img_size'];
                $resized['height'] = false;
            }

            if (!empty($data['img_size']) && $data['img_size'] === 'custom' || $data['img_size'] === 'width') {
                $resized['width'] = $data['img_width'] ?? false;
                $resized['height'] = $data['img_size'] === 'custom' && $data['img_height'] ? $data['img_height'] : false;
            }

            $ratio = $data['img_size_ratio'];
            if (empty($ratio)) {
                $ratio = $original['width'] >= $original['height']
                    ? $original['width'] / $original['height']
                    : $original['height'] / $original['width'];

                    
                $ratio = $original['width'] >= $original['height'] ? strval($ratio) . ':1' : '1:' . strval($ratio);
            }

            if (!empty($resized['width']) && !$resized['height']) {
                $resized['height'] = municipio_to_aspect_ratio($ratio, array($resized['width']))[1];
                $resized['src'] = wp_get_attachment_image_src($attachmentId, array($resized['width'], $resized['height']));
            }

            return array_merge($attachment, array(
                'url' => !empty($resized['src']) ? $resized['src']['0'] : $original['src']['0'],
                'width' => !empty($resized['src']) ? $resized['src']['1'] : $original['src']['1'],
                'height' => !empty($resized['src']) ? $resized['src']['2'] : $original['src']['2'],
            ));
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
    $element = new VcSingleImage();
    echo $element->output($atts, $content, 'vc_single_image');
endif;
