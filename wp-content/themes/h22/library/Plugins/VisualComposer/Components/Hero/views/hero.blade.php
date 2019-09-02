<div{!! html_build_attributes($attributes) !!}>
    @isset($background_image)
        <img{!! html_build_attributes($background_image['attributes']) !!}>
    @endisset
    @if(!empty($heading))
        <h2 class="c-hero__title">{{ $heading }}</h2>
    @endif
    @if($body)
        <p class="c-hero__body">{{ $body }}</p>
    @endif
</div>
