<?php 


if (function_exists('acf_add_local_field_group')) {

    acf_add_local_field_group(array(
    'key' => 'group_5d110a7a781b3',
    'title' => __('Page Builder settings', 'h22'),
    'fields' => array(
        0 => array(
            'key' => 'field_5d110a8312762',
            'label' => __('Page Template', 'h22'),
            'name' => 'page_builder_template',
            'type' => 'post_object',
            'instructions' => __('This will override all inherited templates.', 'h22'),
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
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'post',
            ),
        ),
        1 => array(
            0 => array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'page',
            ),
        ),
        2 => array(
            0 => array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'news',
            ),
        ),
        3 => array(
            0 => array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'projects',
            ),
        ),
        4 => array(
            0 => array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'product',
            ),
        ),
        5 => array(
            0 => array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'speaker',
            ),
        ),
    ),
    'menu_order' => -2147483648,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
));

}