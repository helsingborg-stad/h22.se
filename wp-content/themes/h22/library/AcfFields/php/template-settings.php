<?php 

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
    'key' => 'group_5d1086c70b64e',
    'title' => __('Template settings', 'h22'),
    'fields' => array(
        0 => array(
            'key' => 'field_5d1086db06f8a',
            'label' => __('Lock Template', 'h22'),
            'name' => 'lock_template',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'message' => '',
            'default_value' => 0,
            'ui' => 1,
            'ui_on_text' => __('Enabled', 'h22'),
            'ui_off_text' => __('Disabled', 'h22'),
        ),
        1 => array(
            'key' => 'field_5d108753eb0b0',
            'label' => __('Template Type', 'h22'),
            'name' => 'template_type',
            'type' => 'taxonomy',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'taxonomy' => 'pb-template-type',
            'field_type' => 'select',
            'allow_null' => 1,
            'add_term' => 0,
            'save_terms' => 1,
            'load_terms' => 1,
            'return_format' => 'id',
            'multiple' => 0,
        ),
        2 => array(
            'key' => 'field_5d10878b0478e',
            'label' => __('Save as site template', 'h22'),
            'name' => 'save_as_site_template',
            'type' => 'true_false',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'message' => '',
            'default_value' => 0,
            'ui' => 0,
            'ui_on_text' => '',
            'ui_off_text' => '',
        ),
    ),
    'location' => array(
        0 => array(
            0 => array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'pb-template',
            ),
        ),
    ),
    'menu_order' => -500,
    'position' => 'side',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => array(
        0 => 'permalink',
        1 => 'excerpt',
        2 => 'discussion',
        3 => 'comments',
        4 => 'slug',
        5 => 'format',
        6 => 'page_attributes',
        7 => 'send-trackbacks',
    ),
    'active' => true,
    'description' => '',
));
}