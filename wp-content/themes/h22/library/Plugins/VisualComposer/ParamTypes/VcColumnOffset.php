<?php

namespace H22\Plugins\VisualComposer\ParamTypes;

use Philo\Blade\Blade;

class VcColumnOffset extends \Vc_Column_Offset
{
    public function __construct()
    {
        $this->column_width_list = array(
            __('1 column - 1/12', 'h22') => '1',
            __('2 columns - 1/6', 'h22') => '2',
            __('3 columns - 1/4', 'h22') => '3',
            __('4 columns - 1/3', 'h22') => '4',
            __('5 columns - 5/12', 'h22') => '5',
            __('6 columns - 1/2', 'h22') => '6',
            __('7 columns - 7/12', 'h22') => '7',
            __('8 columns - 2/3', 'h22') => '8',
            __('9 columns - 3/4', 'h22') => '9',
            __('10 columns - 5/6', 'h22') => '10',
            __('11 columns - 11/12', 'h22') => '11',
            __('12 columns - 1/1', 'h22') => '12',
        );

        vc_add_shortcode_param('column_offset_mod', array($this, 'renderParam'), \H22\Helper\FileSystem::themeUrl(dirname(__FILE__)) . '/VcColumnOffset.js?v=' . filemtime(H22_PATH . 'library/Plugins/VisualComposer/ParamTypes' . '/VcColumnOffset.js'));
    }

    /**
     * @param $size
     *
     * @return string
     */
    public function sizeControl($size)
    {
        if ('md' === $size) {
            return '<span class="vc_description">' . __('Default value from width attribute', 'h22') . '</span>';
        }

        $empty_label = 'xs' === $size ? '' : __('Inherit from smaller', 'h22');
        $output = '<select name="vc_col_' . $size . '_size" class="vc_column_offset_field" data-type="size-' . $size . '">' . '<option value="" style="color: #ccc;">' . $empty_label . '</option>';
        foreach ($this->column_width_list as $label => $index) {
            $value = 'vc_col-' . $size . '-' . $index;
            $output .= '<option value="' . $value . '"' . (in_array($value, $this->data) ? ' selected="true"' : '') . '>' . $label . '</option>';
        }
        $output .= '</select>';

        return $output;
    }
    
    /**
     * @param $settings
     * @param $value
     */
    public function renderParam($settings, $value)
    {
        $this->settings = $settings;
        $this->value = $value;

        $data = array(
            'settings' => $this->settings,
            'value' => $this->value,
            'data' => $this->valueData(),
            'sizes' => $this->size_types,
            'param' => $this,
        );
        $script = '<script type="text/javascript">
            window.VcI8nColumnOffsetParam = ' . json_encode(array(
                'inherit' => __('Inherit: ', 'h22'),
                'inherit_default' => __('Inherit from default', 'h22'),
            )) . '</script>';
        
        $blade = new Blade(H22_PATH . 'library/Plugins/VisualComposer/ParamTypes', WP_CONTENT_DIR . '/uploads/cache/blade-cache');
        return $blade->view()->make('vc-column-offset', $data)->render() . $script;
    }
}
