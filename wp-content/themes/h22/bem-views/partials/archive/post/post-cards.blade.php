<?php global $post;

$image = municipio_get_thumbnail_source(null, array(400, 225));
?>

<div class="c-card c-card--clickable @empty($image) c-card--without-image @endempty">
    @if( $image )
        <div class="c-card__image-wrapper @if($image) c-card__image-wrapper--4by3 @endif">
            <img class="c-card__image" src="{{ $image }}"/>
        </div>
    @endif
    <div class="c-card__body">
        @if(get_field('archive_' . sanitize_title(get_post_type()) . '_feed_date_published', 'option') )
            <div class="c-card__meta">
              {{ in_array(get_field('archive_' . sanitize_title(get_post_type()) . '_feed_date_published', 'option'), array('datetime', 'date')) ? the_time(get_option('date_format')) : '' }}
              {{ in_array(get_field('archive_' . sanitize_title(get_post_type()) . '_feed_date_published', 'option'), array('datetime', 'time')) ? the_time(get_option('time_format')) : '' }}
            </div>
        @endif
        <h2 class="c-card__title">
            <a href="{{ the_permalink() }}" class="c-card__link">
                {{ the_title() }}
            </a>
        </h2>
        <div class="c-card__text">
            {{ the_excerpt() }}
        </div>
    </div>
</div>
