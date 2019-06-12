<div class="c-element">
    <div{!! html_build_attributes($attributes) !!}>
        @if($heading)
            <h2 class="u-text-center c-post-list__title">{{ $heading }}</h2>
        @endif
        <div class="grid">
            @foreach ($posts as $post)
                <div class="grid-md-{{ 12 / $columns }}">
                    {!! $post !!}
                </div>
            @endforeach
        </div>
        <div class="u-text-center c-post-list__link">
            @isset($archive_link)
                <a{!! html_build_attributes($archive_link['attributes']) !!}>
                    {{ $archive_link['text'] }}
                </a>
            @endisset
        </div>
    </div>
</div>
