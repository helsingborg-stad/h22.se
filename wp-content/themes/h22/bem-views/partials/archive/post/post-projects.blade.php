<?php global $post;

$image = municipio_get_thumbnail_source(null, array(400, 300), '4:3');
$terms = get_the_terms(get_queried_object_id(), get_post_type() === 'project' ? 'organisation' : 'post_tag');

if (is_array($terms) && !empty($terms)) {
    $terms = implode(array_map(function($termObject) {
        return $termObject->name;
    }, $terms), ', ');
}
?>

<div class="c-card c-card--clickable @empty($image) c-card--without-image @endempty">
        <div class="c-card__image-wrapper c-card__image-wrapper--4by3">
            @if( $image )
                <img class="c-card__image" src="{{ $image }}"/>
            @endif
        </div>

    <div class="c-card__body">
        @if(get_field('archive_' . sanitize_title(get_post_type()) . '_feed_date_published', 'option') )
            <div class="c-card__meta">
                @if ($terms)
                    {{$terms}}
                @else 
                    {{get_post_type_object(get_post_type())->labels->singular_name}}
                @endif
            </div>
        @endif
        <h2 class="c-card__title">
            <a href="{{ the_permalink() }}" class="c-card__link">
                {{ the_title() }}
            </a>
        </h2>
        <div class="c-card__text">
            {{\H22\Content\Excerpt::getExcerpt($post->ID, 24, true)}}
        </div>
    </div>
    <div class="c-card__footer">
            <a class="c-card__link c-card__link--read-more c-card__link--right" href="{{get_permalink()}}">
                Read more
            </a>
        </div>
</div>
