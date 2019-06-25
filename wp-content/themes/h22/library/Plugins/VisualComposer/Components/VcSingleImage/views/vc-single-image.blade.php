<div class="c-single-image c-single-image--{!! $single_image['size'] !!} {!! $el_class !!}">
    <div class="c-single-image__inner">
        <div class="c-single-image__image-wrapper">
            <img {!! html_build_attributes($single_image['attributes']) !!}>
        </div>
        @if($single_image['caption'])
        <p class="c-single-image__image-caption">{{$single_image['caption']}}</p>
        @endif
    </div>
</div>
