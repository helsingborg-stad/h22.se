{!! $args['before_widget'] !!}
    @if ($link)
        <a class="c-brand" href="{{ $link_url }}" title="{{ $link_title }}" target="{{ $link_target }}" data-tooltip="{{ $link_title }}" style="max-width: {{ $maxWidth }}px;">
            {!! $logotype !!}
        </a>
    @else
        {!! $logotype !!}
    @endif
{!! $args['after_widget'] !!}
