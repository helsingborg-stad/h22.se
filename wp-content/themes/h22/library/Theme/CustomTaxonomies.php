<?php

namespace H22\Theme;

class CustomTaxonomies
{
    public function __construct()
    {
        new \H22\Entity\Taxonomy(
            _x('Organisations', 'Post type plural', 'h22'),
            _x('Organisation', 'Post type singular', 'h22'),
            'organisation',
            array('projects'),
            array('hierarchical' => true)
        );
    }
}
