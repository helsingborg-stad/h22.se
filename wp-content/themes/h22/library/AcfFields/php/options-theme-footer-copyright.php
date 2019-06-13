<?php

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_56c5d852a31121',
        'title' => 'Footer Copyright',
        'fields' => array(
            0 => array(
                'key' => 'field_56c5d4ed34923',
                'label' => __('Copyright text', 'h22'),
                'name' => 'footer_copyright',
                'type' => 'textarea',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
            ),
            1 => array(
                'key' => 'field_56t8050930333',
                'label' => __('Show Copyright', 'h22'),
                'name' => 'footer_copyright_show',
                'type' => 'true_false',
                'instructions' => __(
                    'If enabled the copyright text will be displayed at the bottom of the page',
                    'h22'
                ),
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => 0,
                'message' => __('Display copyright text', 'h22'),
                'ui' => 0,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
        ),
        'location' => array(
            0 => array(
                0 => array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-footer',
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
        'local' => 'php',
    ));
}
