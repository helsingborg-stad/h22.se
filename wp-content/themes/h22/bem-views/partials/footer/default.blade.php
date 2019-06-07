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
    <div class="c-footer c-footer--h22">
        <div class="c-footer__body">
            
        </div>
    </div>
@stop
