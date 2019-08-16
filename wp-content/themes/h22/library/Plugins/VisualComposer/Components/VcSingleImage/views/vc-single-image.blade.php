@if (!empty($single_image))
    <div class="c-element {{$noMargin ? 'u-mb-0' : ''}}">
        <div {!! html_build_attributes($attributes) !!}>
            <div class="c-single-image__inner">
                <div class="c-single-image__image-wrapper">
                    @if (!empty($single_image['src']))
                        @if (!empty($linkAttributes))
                        <a {!! html_build_attributes($linkAttributes) !!}>
                            <img {!! html_build_attributes($single_image['attributes']) !!}>
                        </a>
                        @else
                            <img {!! html_build_attributes($single_image['attributes']) !!}>
                        @endif
                    @endif
                </div>
                @if($single_image['caption'])
                    <p class="c-single-image__image-caption">{{$single_image['caption']}}</p>
                @endif
            </div>
        </div>
    </div>
@endif
