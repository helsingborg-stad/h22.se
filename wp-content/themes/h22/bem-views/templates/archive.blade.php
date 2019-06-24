@extends('templates.master')


@section('before-layout')

    @if (get_field('archive_' . sanitize_title($postType) . '_filter_position', 'option') == 'top')
        @includeFirst(["partials.archive-" . sanitize_title($postType) . "-filters", "partials.archive-filters"])
    @endif

@stop

@section('above')
    @include('components.breadcrumbs')
@stop

@section('layout')

    @include('partials.archive.archive-title')

    {{do_action('views/templates/archive/before-archive')}}
    <div class="container">
        @if (have_posts())
            <div class="archive s-archive s-archive-template-{{sanitize_title($template)}}  s-{{sanitize_title($postType)}}-archive grid grid--columns" @if (apply_filters('archive_equal_container', false, $postType, $template)) data-equal-container @endif>

                @if (get_field('archive_' . sanitize_title($postType) . '_filter_position', 'option') == 'content')
                    @includeFirst(["partials.archive-" . sanitize_title($postType) . "-filters", "partials.archive-filters"])
                @endif

                <?php $postNum = 0; ?>
                @while(have_posts())
                    {!! the_post() !!}
                    <div class="grid-xs-12 {{ $grid_size }}">
                        @includeIf('partials.archive.post.post-' . $template)
                    </div>
                    <?php $postNum++; ?>
                @endwhile

                <div class="grid-sm-12 text-center">
                    {!!
                        paginate_links(array(
                            'type' => 'list',
                            'prev_text' => __('Previous', 'h22'),
                            'next_text' => __('Next', 'h22'),
                        ))
                    !!}

                </div>
            </div>
        @else
            <div class="notice info pricon pricon-info-o pricon-space-right"><?php _e(
                'No posts to show',
                'municipio'
            ); ?>…</div>
        @endif
    </div>
    {{do_action('views/templates/archive/after-archive')}}
@stop
