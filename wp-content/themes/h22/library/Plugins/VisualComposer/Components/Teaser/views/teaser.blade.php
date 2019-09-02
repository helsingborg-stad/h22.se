<div class="c-element">
    <div{!! html_build_attributes($attributes) !!}>
        <div class="c-teaser__meta">{{ $meta_heading }}</div>
        <h2 class="h1">{{ $heading }}</h2>
        @if (!empty($preamble))
            <p class="preamble">{{ $preamble }}</p>
        @endif
       
        {!! $content !!}
        @if ($link)
            <a{!! html_build_attributes($link['attributes']) !!}>
                {{ $link['text'] }}
            </a>
        @endif
    </div>
</div>
