<div{!! html_build_attributes($attributes) !!}>
	<div class="c-teaser__meta">{{ $meta_heading }}</div>
	<h2>{{ $heading }}</h2>
	<p class="preamble">{{ $preamble }}</p>
	{!! $content !!}
	@if ($link)
		<a{!! html_build_attributes($link['attributes']) !!}>
			{{ $link['text'] }}
		</a>
	@endif
</div>
