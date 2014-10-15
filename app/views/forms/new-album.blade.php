{{ Form::open(array('url' => 'album', 'method' => 'POST', 'class' => 'form-horizontal', 'files' => true)) }}
	
	<div class="form-group">	
		{{ Form::label('album_name', Lang::get('gallery.name') . ':', array('class' => 'form-label col-md-2')) }}
		<div class="col-md-5">
			{{ Form::text('album_name', null, $options = array('size'=>'50', 'class' => 'form-control')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('album_description', Lang::get('gallery.desc') . ':', array('class' => 'form-label col-md-2')) }}
		<div class="col-md-5">
			{{ Form::textarea('album_description', null, $options = array('size'=>'50x5', 'class' => 'form-control')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('cover_photo_path', Lang::get('gallery.path') . ':', array('class' => 'form-label col-md-2')) }}
		<div class="col-md-5">
			{{ Form::file('cover_photo_path') }}
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-5">
			{{ Form::submit(Lang::get('gallery.submit'), array('class' => 'btn')) }}
		</div>
	</div>

{{ Form::close() }}