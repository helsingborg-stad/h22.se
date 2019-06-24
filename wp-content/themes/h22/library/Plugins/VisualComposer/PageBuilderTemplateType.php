<?php

namespace H22\Plugins\VisualComposer;

class PageBuilderTemplateType
{
    public function __construct()
    {
        add_action('H22/Entity/Taxonomy/AfterRegisterTaxonomy', array($this, 'setDefaultTerms'), 10, 3);
        $this->registerTaxonomy();
    }

    public function setDefaultTerms($slug, $postTypes, $args)
    {
        $taxonomySlug = PageBuilderTemplate::$postTypeSlug . '-type';
        if ($slug !== $taxonomySlug) {
            return;
        }

        $defaultTerms = array('Archive', 'Single', 'Header', 'Footer');
        $existingTerms = get_terms(array(
            'taxonomy' => $taxonomySlug,
            'hide_empty' => false,
            'fields' => 'names'
        ));

        foreach ($defaultTerms as $termName) {
            if (empty($existingTerms) || !in_array($termName, $existingTerms)) {
                wp_insert_term(
                    $termName,
                    $taxonomySlug,
                    array(
                        'slug' => sanitize_title($termName),
                    )
                );
            }
        }
    }


    public function registerTaxonomy()
    {
        new \H22\Entity\Taxonomy(
            __('Template Types', 'h22'),
            __('Template Type', 'h22'),
            PageBuilderTemplate::$postTypeSlug . '-type',
            array(PageBuilderTemplate::$postTypeSlug),
            array(
                'hierarchical' => true,
                'publicly_queryable' => false,
                'show_in_menu' => false,
                'meta_box_cb' => false,
                'show_admin_column' => true,
                'show_in_quick_edit' => false
            )
        );
    }
}
