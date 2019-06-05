@extends('templates.master')
@section('layout')
    @while(have_posts())
    {!! the_post() !!}
    {!! the_content() !!}
    @endwhile
@stop