<?php

namespace H22\Widget;

class Widgets
{
    public function __construct()
    {
        add_action('widgets_init', array($this, 'headerWidgets'), 99);
    }

    public function headerWidgets()
    {
        unregister_widget('\Municipio\Widget\Brand\Brand');
        register_widget(new \H22\Widget\Brand\Brand());
    }
}
