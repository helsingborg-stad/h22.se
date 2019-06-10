<div{!! html_build_attributes($attributes) !!}>
    @isset($background_video)
        <video{!! html_build_attributes($background_video['attributes']) !!}>
        @foreach ($background_video['sources'] as $source)
            <source{!! html_build_attributes($source) !!}>
        @endforeach
    </video>
    @endisset
    {!! $content !!}
</div>
