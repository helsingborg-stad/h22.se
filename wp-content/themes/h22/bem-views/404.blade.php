@extends('templates.master')

@section('layout')
    @includeFirst(['partials.404.' . $post_type, 'partials.404.default'])
@stop
