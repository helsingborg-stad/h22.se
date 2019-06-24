<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5d1104688c6d6',
    'title' => __('Posttype template', 'h22'),
    'fields' => array(
        0 => array(
            'key' => 'field_5d11047f0d923',
            'label' => __('Default template for all posttypes', 'h22'),
            'name' => 'page_builder_template_single',
            'type' => 'post_object',
            'instructions' => __('This will set a default single view template for all posttypes. Define a template on posttype-level to override this one. Leave empty to disable.', 'h22'),
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
                0 => 'pb-template-type:single',
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
                'value' => 'acf-options-post-types',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));
}