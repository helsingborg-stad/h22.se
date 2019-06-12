<?php


if (function_exists('acf_add_local_field_group')) {

    acf_add_local_field_group(array(
    'key' => 'group_6a5ca31651f18',
    'title' => __('Brand / Logo Widget', 'municipio'),
    'fields' => array(
        0 => array(
            'key' => 'field_8a7c1d359he79',
            'label' => __('URL', 'municipio'),
            'name' => 'widget_header_url',
            'type' => 'link',
            'instructions' => __('Link this logo to the following URL:', 'municipio'),
            'required' => 0,
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'widget',
                'operator' => '==',
                'value' => 'widget-header-logo',
            ),
        ),
        1 => array(
            0 => array(
                'param' => 'widget',
                'operator' => '==',
                'value' => 'brand-municipio',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));

}
