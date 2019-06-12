<?php
namespace H22\Plugins\VisualComposer\Components\VcTtaSection;

use H22\Plugins\VisualComposer\Components\BaseComponentController;
use WPBMap;

if (
    !class_exists(
        '\H22\Plugins\VisualComposer\Components\VcTtaSection\VcTtaSection'
    )
):
    class VcTtaSection extends \WPBakeryShortCode
    {
        use BaseComponentController;

        public function __construct()
        {
            add_action('vc_after_init', array($this, 'changeTemplateSource'));
            $this->initBaseController(false);
        }

        public function changeTemplateSource()
        {
            \WPBMap::modify(
                'vc_tta_section',
                'html_template',
                dirname(__FILE__) . '/VcTtaSection.php'
            );
        }

        public function prepareData($data)
        {
            return $data;
        }
    }
endif;

/**
 * From wp-content/plugins/js_composer/include/templates/shortcodes/vc_tta_section.php
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
    $element = new VcTtaSection();
    echo $element->output($atts, $content, 'vc_tta_section');
endif;
