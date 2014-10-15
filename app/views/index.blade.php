@section('content')

	<h1>{{ Lang::get('gallery::gallery.overview') . ' ' . Lang::choice('gallery::gallery.album', 2) }}</h1>

	@if ($albums->count())
		@foreach($albums as $album)

			<div class="col-sm-4 col-md-3">
				<div class="thumbnail">
					<img src='{{ asset("uploads/cover_photos/" . $album->cover_photo_path ) }}' alt="{{ $album->album_name }}"/>
					<div class="caption">
						<h3>{{ $album->album_name }}</h3>
						<p>{{ $album->album_description }}</p>
						<p><a href="/album/{{ $album->album_id }}" class="btn btn-primary btn-block" role="button">View Album</a></p>
					</div>
				</div>
			</div>

		@endforeach

	@else
    	{{ Lang::get('gallery::gallery.none') . Lang::choice('gallery::gallery.album', 2) }}
	@endif

@stop