@extends('partials.header')

@section('before-header-body')
@stop

@section('header-body')
    @if ($mainMenu && !empty($mainMenu))
    <div class="c-header c-header--h22 s-main-menu">
        <div class="c-header__body">
            {!! municipio_get_logotype(get_field('header_logotype', 'option'), get_field('logotype_tooltip', 'option'), true, get_field('header_tagline_enable', 'option')) !!}
            <nav style="margin-left: auto;" class="c-menu c-menu--horizontal">
                <ul class="c-menu__list">
                    @foreach ($mainMenu as $menuItem)
                        <li class="c-menu__item {{implode(' ', $menuItem->classes)}}">
                            <a href="{{$menuItem->url}}" class="c-menu__link">
                                {{$menuItem->title}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>

    @endif
@stop
