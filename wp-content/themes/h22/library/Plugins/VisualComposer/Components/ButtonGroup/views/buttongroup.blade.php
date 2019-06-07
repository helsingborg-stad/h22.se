@if (!empty($buttons))
<div class="c-element">
  <div class="c-button-group c-button-group--align-{{$button_group_placement}}">
      @foreach ($buttons as $button)
      <a{!! html_build_attributes($button['attributes']) !!}>
        {{$button['label']}}
      </a>
      @endforeach
  </div>
</div>
@endif
