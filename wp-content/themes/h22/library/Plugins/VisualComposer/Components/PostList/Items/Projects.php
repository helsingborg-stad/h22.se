<?php
namespace H22\Plugins\VisualComposer\Components\PostList\Items;

class Projects extends PostListItem
{
    public function prepareData($data)
    {
        $data = parent::prepareData($data);
        $data['image_wrapper']['attributes']['class']['ratio'] =
            'c-card__image-wrapper--1by1';
        return $data;
    }
}
