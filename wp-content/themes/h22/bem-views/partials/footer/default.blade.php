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
    <div class="c-footer">
        <div class="c-footer__body">
            @if (is_active_sidebar('footer-area'))
                <?php dynamic_sidebar('footer-area'); ?>
            @endif
        </div>
    </div>
@stop
