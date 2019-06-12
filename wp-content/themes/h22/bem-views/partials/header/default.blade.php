@extends('partials.header')

@section('before-header-body')
@stop

@section('header-body')
    @if ($navigation['mainMenu'])

    <div class="container container--wide hidden-print">
  	<div id="c-header-desktop" class="c-header-desktop ">
  		<div class="c-header-desktop__logo">
        {!! municipio_get_logotype(get_field('header_logotype', 'option'), get_field('logotype_tooltip', 'option'), true, get_field('header_tagline_enable', 'option')) !!}
  		</div>
  		<div class="c-header-desktop__menu-items">
  			{!! $navigation['mainMenu'] !!}
      </div>
      @if (isset($languages) && is_array($languages) && empty($languages))
        @foreach ($languages as $language)
          <a class="c-header-desktop__language" href="{{$language['url']}}">{{$language['name']}}</a>
        @endforeach
      @endif
    </div>

    <div id="c-header-mobile" class="c-header-mobile">
      <div class="c-header-mobile__top">
    		<div class="c-header-mobile__logo">
          {!! municipio_get_logotype(get_field('header_logotype', 'option'), get_field('logotype_tooltip', 'option'), true, get_field('header_tagline_enable', 'option')) !!}
    		</div>

        <button class="c-header-mobile__menu-trigger">
          <span class="c-header-mobile__menu-icon c-header-mobile__menu-icon--open"></span>
        </button>
      </div>
      <div class="c-header-mobile__bottom hidden">
    		<div class="c-header-mobile__menu-items">
    			{!! $navigation['mainMenu'] !!}
    		</div>
        <div class="c-header-mobile__language">
          @if (isset($languages) && is_array($languages) && empty($languages))
            @foreach ($languages as $language)
              <a href="{{$language['url']}}">{{$language['name']}}</a>
            @endforeach
          @endif
        </div>
      </div>
  	</div>
  </div>

    @endif
@stop
