@if (!empty($buttons))
<div class="c-element">
  <div class="c-button-group u-flex-column@xs u-flex-column@sm c-button-group--align-{{$button_group_placement}}">
      @foreach ($buttons as $button)
      <a{!! html_build_attributes($button['attributes']) !!}>
        {{$button['label']}}
      </a>
      @endforeach
  </div>
</div>
@endif
