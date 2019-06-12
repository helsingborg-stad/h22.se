<?php
namespace H22\Plugins\VisualComposer\Components\PostList\Items;

use Philo\Blade\Blade;

class PostListItem extends PostListItemBase
{
    public function prepareData($data)
    {
        $post = $data['post'];

        // Parent Attributes
        $attributes = [
            'class' => ['c-card'],
        ];

        $data['link']['url'] = get_permalink($post);

        if (!empty($data['link']['url'])) {
            $attributes['class'][] = 'c-card--clickable';
        }

        $data['attributes'] = $attributes;

        // Link
        $link_attributes = [];
        $data['link']['attributes'] = $link_attributes;

        // Image_attachment
        $image_attributes = [
            'class' => ['c-card__image'],
        ];

        $thumbnail = get_post_thumbnail_id($post);
        if (!empty($thumbnail)) {
            $data['image'] = wp_get_attachment_metadata($thumbnail);
            $image_attributes['src'] = wp_get_attachment_url($thumbnail);
            $image_attributes['srcset'] = wp_get_attachment_image_srcset(
                $thumbnail
            );
            $image_attributes['alt'] = get_post_meta(
                $thumbnail,
                '_wp_attachment_image_alt',
                true
            );
            $data['image']['attributes'] = $image_attributes;
        }

        // Image ratio
        $image_wrapper_attributes = [
            'class' => ['c-card__image-wrapper', 'c-card__image-wrapper--4by3'],
        ];

        $data['image_wrapper']['attributes'] = $image_wrapper_attributes;

        $data['heading'] = get_the_title($post);

        $data['content'] = get_the_excerpt($post);

        return $data;
    }
}
