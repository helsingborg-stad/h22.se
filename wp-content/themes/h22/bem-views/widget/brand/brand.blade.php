{!! $args['before_widget'] !!}
@if (!empty($link_url) && isset($link_title) && isset($link_target) )
<a class="c-brand" href="{{ $link_url }}" title="{{ $link_title }}" target="{{ $link_target }}" data-tooltip="{{ $link_title }}" style="max-width: {{ $maxWidth }}px;">
    {!! $logotype !!}
</a>
@else
{!! $logotype !!}
@endif
{!! $args['after_widget'] !!}
