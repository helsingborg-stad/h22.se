@extends('partials.footer')

{{-- Above footer --}}
@section('above-footer')
@if (is_active_sidebar('bottom-sidebar'))
<div class="sidebar-bottom-fullwidth">
    <?php dynamic_sidebar('bottom-sidebar'); ?>
</div>
@endif
@stop

@section('footer-body')
<div class="c-footer u-py-8">
    <div class="container container--wide">
        <div class="grid u-justify-content-center u-text-center">
            @if (is_active_sidebar('footer-area'))
            <?php dynamic_sidebar('footer-area'); ?>
            @endif
        </div>
    </div>

    @if (have_rows('footer_icons_repeater', 'option'))
        <div class="container container--wide">
            <div class="grid">
                <div class="grid-xs-12">
                    <ul class="icons-list">
                        @foreach(get_field('footer_icons_repeater', 'option') as $link)
                        <li>
                            <a href="{{ $link['link_url'] }}" target="_blank" class="link-item-light">
                                {!! $link['link_icon'] !!}

                                @if (isset($link['link_title']))
                                <span class="sr-only">{{ $link['link_title'] }}</span>
                                @endif
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="container container--content u-px-0">
    <div class="c-footer__logos u-justify-content-between">
        @if (is_active_sidebar('footer-area-logos'))
        <?php dynamic_sidebar('footer-area-logos'); ?>
        @endif
    </div>
</div>


    <div class="c-footer__copyright">
        @if( get_field('footer_copyright_show', 'option') )
        <p>© {{date("Y")}} {{get_field('footer_copyright', 'option')}}</p>
        @endif
    </div>

</div>

@stop
