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
            <div class="grid">
                @if (is_active_sidebar('footer-area'))
                    <?php dynamic_sidebar('footer-area'); ?>
                @endif
            </div>
        </div>
        <div class="c-footer__logos">
            @if (is_active_sidebar('footer-area-logos'))
                <?php dynamic_sidebar('footer-area-logos'); ?>
            @endif
        </div>
        <div class="c-footer__copyright">
          @if( get_field('footer_copyright_show', 'option') )
            <p>© {{date("Y")}} {{get_field('footer_copyright', 'option')}}</p>
          @endif
        </div>
    </div>
@stop
