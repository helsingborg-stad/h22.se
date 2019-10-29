<div class="c-element">
    <div{!! html_build_attributes($attributes) !!}>
        @if (!empty($meta_heading))
        <div class="c-teaser__meta">{{ $meta_heading }}</div>
        @endif
        @if (!empty($heading))
        <h2 class="h1">{{ $heading }}</h2>
        @endif
        @if (!empty($preamble))
            <p class="preamble">{{ $preamble }}</p>
        @endif
       
        {!! $content !!}
        @if (!empty($link))
            <a{!! html_build_attributes($link['attributes']) !!}>
                {{ $link['text'] }}
            </a>
        @endif
    </div>
</div>
