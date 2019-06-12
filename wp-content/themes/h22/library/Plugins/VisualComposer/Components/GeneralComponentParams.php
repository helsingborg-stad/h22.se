<?php
namespace H22\Plugins\VisualComposer\Components;

trait GeneralComponentParams
{
    public function generalThemeParams($shortcode, $group = '', $weight = 100)
    {
        vc_add_param($shortcode, [
            'param_name' => 'color_theme',
            'type' => 'dropdown',
            'heading' => __('Color theme', 'h22'),
            'value' => array(
                __('Default (inherit)', 'h22') => '',
                __('H22 Red Invert', 'h22') => 'red-invert',
                __('H22 Green Invert', 'h22') => 'green-invert',
                __('H22 Blue Invert', 'h22') => 'blue-invert',
                __('H22 Purple Invert', 'h22') => 'purple-invert',
                __('H22 Red Fill', 'h22') => 'red-fill',
                __('H22 Green Fill', 'h22') => 'green-fill',
                __('H22 Blue Fill', 'h22') => 'blue-fill',
                __('H22 Purple Fill', 'h22') => 'purple-fill',
            ),
            'group' => $group,
            'weight' => $weight,
        ]);
    }

    public function generalTextColorParams($shortcode, $group = '', $weight = 100)
    {
        vc_add_params($shortcode, [
           [
                'param_name' => 'text_color',
                'type' => 'dropdown',
                'heading' => __('Text color', 'h22'),
                'value' => array(
                    __('Default (inherit)', 'h22') => '',
                    __('White', 'h22') => 'white',
                    __('Black', 'h22') => 'black',
                    __('Gray', 'h22') => 'gray',
                    __('H22 Purple', 'h22') => 'purple',
                    __('H22 Red', 'h22') => 'red',
                    __('H22 Green', 'h22') => 'green',
                    __('H22 Blue', 'h22') => 'blue',
                    __('H22 Purple', 'h22') => 'purple',
                    __('Custom', 'h22') => 'custom',
                ),
                'group' => $group,
                'weight' => $weight,
            ],
            [
                'param_name' => 'text_color_hex',
                'type' => 'colorpicker',
                'heading' => __('Color theme', 'h22'),
                'value' => '',
                'group' => $group,
                'weight' => $weight,
                'dependency' => array(
                    'element' => 'text_color',
                    'value' => ['custom']
                )
            ],
        ]);
    }

    public function generalBackgroundParams($shortcode, $group = 'Background', $weight = 1)
    {
        vc_add_params(
            $shortcode,
            [
                [
                    'param_name' => 'bg_color',
                    'type' => 'dropdown',
                    'heading' => __('Background Color', 'h22'),
                    'value' => array(
                        __('Default (inherit)', 'h22') => '',
                        __('Gray', 'h22') => 'gray-lighter',
                        __('White', 'h22') => 'white',
                        __('Black', 'h22') => 'black',
                        __('H22 Red', 'h22') => 'red',
                        __('H22 Blue', 'h22') => 'blue',
                        __('H22 Green', 'h22') => 'green',
                        __('H22 Purple', 'h22') => 'purple',
                        __('Custom', 'h22') => 'custom',
                    ),
                    'group' => $group,
                    'weight' => $weight
                ],
                [
                    'param_name' => 'bg_color_hex',
                    'type' => 'colorpicker',
                    'heading' => __('Background Color', 'h22'),
                    'value' => '',
                    'group' => $group,
                    'weight' => $weight,
                    'dependency' => array(
                        'element' => 'bg_color',
                        'value' => ['custom']
                    )
                ],
                [
                    'param_name' => 'bg_image',
                    'type' => 'attach_image',
                    'heading' => __('Background Image', 'h22'),
                    'value' => '',
                    'group' => $group,
                    'weight' => $weight
                ],
                [
                    'param_name' => 'bg_size',
                    'type' => 'dropdown',
                    'heading' => __('Background Image Size', 'h22'),
                    'value' => array(
                        __('Default (inherit)', 'h22') => '',
                        __('Cover', 'h22') => 'cover',
                        __('Contain', 'h22') => 'contain',
                        __('Custom', 'h22') => 'custom',
                    ),
                    'group' => $group,
                    'weight' => $weight,
                    'dependency' => array(
                        'element' => 'bg_image',
                        'not_empty' => true
                    )
                ],
                [
                    'param_name' => 'bg_size_custom',
                    'type' => 'textfield',
                    'heading' => __('Custom Background Size', 'h22'),
                    'value' => '',
                    'group' => $group,
                    'weight' => $weight,
                    'dependency' => array(
                        'element' => 'bg_size',
                        'value' => ['custom']
                    )
                ],
                [
                    'param_name' => 'bg_pos',
                    'type' => 'dropdown',
                    'heading' => __('Background Position', 'h22'),
                    'value' => array(
                        __('Default (inherit)', 'h22') => '',
                        __('Center', 'h22') => 'center',
                        __('Top', 'h22') => 'top',
                        __('Bottom', 'h22') => 'bottom',
                        __('Left', 'h22') => 'left',
                        __('Right', 'h22') => 'right',
                        __('Custom', 'h22') => 'custom',
                    ),
                    'group' => $group,
                    'weight' => $weight,
                    'dependency' => array(
                        'element' => 'bg_image',
                        'not_empty' => true
                    )
                ],
                [
                    'param_name' => 'bg_pos_custom',
                    'type' => 'textfield',
                    'heading' => __('Custom Background Position', 'h22'),
                    'value' => '',
                    'group' => $group,
                    'weight' => $weight,
                    'dependency' => array(
                        'element' => 'bg_pos',
                        'value' => ['custom']
                    )
                ],
                [
                    'param_name' => 'bg_repeat',
                    'type' => 'dropdown',
                    'heading' => __('Background Repeat', 'h22'),
                    'value' => array(
                        __('Default (inherit)', 'h22') => '',
                        __('No Repeat', 'h22') => 'no-repeat',
                        __('Repeat', 'h22') => 'repeat',
                        __('Repeat X', 'h22') => 'repeat-x',
                        __('Repeat Y', 'h22') => 'repeat-y',
                    ),
                    'group' => $group,
                    'weight' => $weight,
                    'dependency' => array(
                        'element' => 'bg_size',
                        'value' => ['custom']
                    )
                ],
                [
                    'param_name' => 'overlay',
                    'type' => 'dropdown',
                    'heading' => __('Background Overlay', 'h22'),
                    'value' => array(
                        __('None', 'h22') => '',
                        __('20%', 'h22') => '20',
                        __('40%', 'h22') => '40',
                        __('60%', 'h22') => '60',
                    ),
                    'group' => $group,
                    'weight' => $weight
                ]
            ]
        );
    }
}
