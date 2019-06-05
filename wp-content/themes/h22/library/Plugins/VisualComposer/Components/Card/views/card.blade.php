<div{!! html_build_attributes($attributes) !!}>
	@isset($image)
		<div{!! html_build_attributes($image_wrapper['attributes']) !!}>
			<img{!! html_build_attributes($image['attributes']) !!} />
		</div>
	@endisset
	<div class="c-card__body">
		<h2 class="c-card__title">
			@empty ($link['url'])
				{{ $heading }}
			@else
				<a
					href="{{ $link['url'] }}"
					class="c-card__link"
					{!! html_build_attributes($link['attributes']) !!}
				>
					{{ $heading }}
				</a>
			@endempty
		</h2>
		<div class="c-card__text">
			{!! $content !!}
		</div>
	</div>
</div>