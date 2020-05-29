<?php
namespace H22\Theme;

class Archive
{
    public function __construct()
    {
        add_filter('acf/load_field/name=archive_projects_post_style', array($this, 'customPostStyleTemplates'), 10, 3);
        add_filter('acf/load_field/name=archive_toolbox_post_style', array($this, 'customPostStyleTemplates'), 10, 3);
        add_filter('acf/load_field/name=archive_news_post_style', array($this, 'customPostStyleTemplates'), 10, 3);
        add_filter('acf/load_field/name=archive_post_post_style', array($this, 'customPostStyleTemplates'), 10, 3);
        add_filter('acf/load_field/name=archive_partners_post_style', array($this, 'customPostStyleTemplates'), 10, 3);
    }

    public function customPostStyleTemplates($field)
    {
        $field['choices']['projects'] = 'Project Cards (H22 Theme)';
        $field['choices']['news'] = 'News Cards (H22 Theme)';
        $field['choices']['partner'] = 'Partner Cards (H22 Theme)';

        return $field;
    }
}
