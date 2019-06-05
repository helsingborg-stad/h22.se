<?php
namespace H22\Helper;

class Styleguide extends \Municipio\Helper\Styleguide
{
    public static $THEME_H22 = 'h22';

    public static $CUSTOM_THEMES = array('h22');

    public static function getCurrentTheme()
    {
        return trim(get_field('color_scheme', 'option'));
    }

    public function isCustomTheme()
    {
        return in_array(self::getCurrentTheme(), self::$CUSTOM_THEMES);
    }
}
