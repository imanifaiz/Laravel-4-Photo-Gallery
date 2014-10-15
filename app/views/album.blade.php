@section('content')

	<h1>{{ Lang::get('gallery::gallery.overview') . ' ' . Lang::choice('gallery::gallery.album', 1) . ': ' . $album->album_name }}
	
		{{ Form::open(array('method' => 'DELETE', 'url' => array('album', $album->album_id), 'class' => 'pull-right')) }}
			{{ link_to("edit/album/$album->album_id", Lang::get('gallery::gallery.edit'), array('class' => 'btn btn-info')) }}
			{{ link_to("new/photo/$album->album_id", 'Add Photo', array('class' => 'btn btn-primary')) }}
			
		    {{ Form::submit(Lang::get('gallery::gallery.delete'), array('class' => 'btn btn-danger')) }}
	    {{ Form::close() }}

	</h1>
    
	@if ($albumPhotos->count())
		<div id="images" class="row">

			@foreach($albumPhotos as $photo)
				<div class="col-sm-4 col-md-3">
					<div class="thumbnail text-center">
						<a href="/uploads/photos/{{ $photo->photo_path }}"><img src='{{ asset("uploads/thumbnail_photos/" . $photo->photo_path ) }}' alt="{{ $photo->photo_name }}" /></a>
						<div class="caption">
							<h3>{{ $photo->photo_name }}</h3>
							<p>{{ $photo->photo_description }}</p>
							<p class="display-order">1</p>
							<p><a href="/photo/{{ $photo->photo_id }}" class="btn btn-primary btn-block" role="button">View Photo</a></p>
						</div>
					</div>
				</div>
			@endforeach
			
		</div><!-- EO .row -->
		<?php echo $albumPhotos->links(); ?>

	@else
    	{{ Lang::get('gallery::gallery.none') . Lang::choice('gallery::gallery.photo', 2) }}
	@endif

@stop