<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5dde7c5d9ace7',
    'title' => __('Polylang Language Switcher', 'h22'),
    'fields' => array(
        0 => array(
            'key' => 'field_5dde7c76eb557',
            'label' => __('Polylang Language Switcher Settings', 'h22'),
            'name' => 'polylang_language_switcher_settings',
            'type' => 'select',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'choices' => array(
                'enabled' => __('Enabled', 'h22'),
                'disabled' => __('Disabled', 'h22'),
                'logged-in' => __('Enabled for logged in users', 'h22'),
            ),
            'default_value' => array(
                0 => __('enabled', 'h22'),
            ),
            'allow_null' => 0,
            'multiple' => 0,
            'ui' => 0,
            'return_format' => 'value',
            'ajax' => 0,
            'placeholder' => '',
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'options_page',
                'operator' => '==',
                'value' => 'acf-options-header',
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