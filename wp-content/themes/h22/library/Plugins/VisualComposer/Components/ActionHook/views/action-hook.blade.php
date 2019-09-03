@if (!empty($action_name))
    <div class="c-element @isset($el_class){{$el_class}}@endisset">
        @if (!empty($disableOutput))
           <span><b>ACTION HOOK:</b> {{$action_name}}</span>
        @else
            <?php do_action($action_name) ?>
        @endif
    </div>
@endif
