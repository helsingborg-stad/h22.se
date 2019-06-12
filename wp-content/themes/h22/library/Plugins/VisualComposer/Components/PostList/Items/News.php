<?php
namespace H22\Plugins\VisualComposer\Components\PostList\Items;

class News extends PostListItem
{
    public function prepareData($data)
    {
        $data = parent::prepareData($data);
        $data['meta'] = get_the_date();
        return $data;
    }
}
