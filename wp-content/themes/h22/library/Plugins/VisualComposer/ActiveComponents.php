<?php
namespace H22\Plugins\VisualComposer;

class ActiveComponents
{
    protected $customComponents = array();
    protected $allowedComponentsDefault = array(
        'vc_row',
        'vc_column',
        // 'vc_gitem',
        // 'vc_gitem_row',
        // 'vc_gitem_col',
        // 'vc_gitem_post_tags',
        // 'vc_gitem_post_title',
        // 'vc_gitem_post_excerpt',
        // 'vc_gitem_post_date',
        // 'vc_gitem_image',
        // 'vc_gitem_animated_block',
        // 'vc_gitem_zone',
        // 'vc_gitem_zone_a',
        // 'vc_gitem_zone_b',
        // 'vc_gitem_zone_c',
        // 'vc_gitem_post_author',
        // 'vc_gitem_post_categories',
        // 'vc_gitem_post_meta',
        // 'vc_btn',
    );
    protected static $instance = null;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public static function getInstance()
    {
        static $instance = false;
        if ($instance === false) {
            // Late static binding (PHP 5.3+)
            $instance = new static();
        }

        return $instance;
    }

    public function getComponents()
    {
        return $this->customComponents;
    }

    public function addComponent($vcName)
    {
        if (array_search($vcName, $this->customComponents) === false) {
            $this->customComponents[] = $vcName;
        }
    }

    public function getAllowedComponents($allowedComponents)
    {
        $templateSlug = get_page_template_slug();
        $postId = get_the_ID();
        if (
            empty($templateSlug) &&
            isset($_GET['post']) &&
            is_numeric($_GET['post'])
        ) {
            // Try to find the id if request was made by admin
            $postId = intval($_GET['post']);
            $templateSlug = get_page_template_slug($postId);
        }
        return apply_filters(
            'helsingborg-h22/visual-composer/allowed-components',
            array_merge(
                $this->allowedComponentsDefault,
                $this->customComponents,
                $allowedComponents
            ),
            $templateSlug,
            $postId,
            $this->allowedComponentsDefault,
            $this->customComponents,
            $allowedComponents
        );
    }
}
