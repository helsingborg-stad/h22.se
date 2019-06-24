<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5d10c0d7d43cf',
    'title' => __('Archive template', 'h22'),
    'fields' => array(
        0 => array(
            'key' => 'field_5d10c0e60933c',
            'label' => __('Default template for archives', 'h22'),
            'name' => 'page_builder_template_archive',
            'type' => 'post_object',
            'instructions' => __('This will set a default template for all archives (including taxonomies etc). Define a template on posttype-level to override this one. Leave empty to disable.', 'h22'),
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'post_type' => array(
                0 => 'pb-template',
            ),
            'taxonomy' => array(
                0 => 'pb-template-type:archive',
            ),
            'allow_null' => 1,
            'multiple' => 0,
            'return_format' => 'object',
            'ui' => 1,
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'acf-options-archives',
            ),
        ),
    ),
    'menu_order' => -500,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));
}