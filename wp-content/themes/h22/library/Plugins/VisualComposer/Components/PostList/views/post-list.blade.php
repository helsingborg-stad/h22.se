<div class="c-element">
    <div{!! html_build_attributes($attributes) !!}>
        @if($heading)
            <h2 class="u-text-center">{{ $heading }}</h2>
        @endif
        <div class="grid">
            @foreach ($posts as $post)
                <div class="grid-md-4">
                    {!! $post !!}
                </div>
            @endforeach
        </div>
        <div class="u-text-center">
            @isset($archive_link)
                <a{!! html_build_attributes($archive_link['attributes']) !!}>
                    {{ $archive_link['text'] }}
                </a>
            @endisset
        </div>
    </div>
</div>
