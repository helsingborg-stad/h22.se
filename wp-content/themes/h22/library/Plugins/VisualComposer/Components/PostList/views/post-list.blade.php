<div{!! html_build_attributes($attributes) !!}>
    @if($heading)
        <h2 class="u-text-center">{{ $heading }}</h2>
    @endif
    <div class="grid">
        @foreach ($posts as $post)
            <div class="grid-md-4">
                {!! $post !!}
            </div>
        @endforeach
    </div>
</div>
