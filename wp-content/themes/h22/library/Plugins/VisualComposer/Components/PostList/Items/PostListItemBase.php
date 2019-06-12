<?php
namespace H22\Plugins\VisualComposer\Components\PostList\Items;

use Doctrine\Common\Inflector\Inflector;
use Philo\Blade\Blade;

class PostListItemBase
{
    protected $data;

    public function __construct($post)
    {
        $this->data = ['post' => $post];
    }

    public function render()
    {
        $data = $this->prepareData($this->data);

        $blade = new Blade(
            [
                get_template_directory() . '/bem-views',
                get_template_directory() . '/views',
                get_stylesheet_directory() . '/bem-views',
                get_stylesheet_directory() . '/views',
                dirname(dirname(__FILE__)) . '/views',
            ],
            WP_CONTENT_DIR . '/uploads/cache/blade-cache'
        );

        // Convert namespace to blade view name
        $view = implode(
            '/',
            array_map(function ($str) {
                return str_replace('_', '-', Inflector::tableize($str));
            }, array_slice(explode('\\', get_class($this)), 4))
        );

        return $blade
            ->view()
            ->make($view, $data)
            ->render();
    }

    public function prepareData($data)
    {
        return $data;
    }
}
