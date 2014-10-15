{{ Form::open(array('url' => 'photo', 'method' => 'POST', 'files' => true, 'class' => 'form-horizontal')) }}

	<div class="form-group">	
		{{ Form::label('photo_name', Lang::get('gallery.name') . ':', array('class' => 'form-label col-md-2')) }}
		<div class="col-md-6">
			{{ Form::text('photo_name', null, $options = array('size'=>'50', 'class' => 'form-control'), array()) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('photo_path', Lang::get('gallery.path') . ':', array('class' => 'form-label col-md-2')) }}
		<div class="col-md-6">
			{{ Form::file('photo_path') }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('album_id', Lang::choice('gallery.album', 1) . ':', array('class' => 'form-label col-md-2')) }}
		<div class="col-md-4">
			{{ Form::select('album_id', $dropdown, null, array('class' => 'form-control')) }}
		</div>
	</div>

	<div class="form-group">
		{{ Form::label('photo_description', Lang::get('gallery.desc') . ':', array('class' => 'form-label col-md-2')) }}
		<div class="col-md-6">
			{{ Form::textarea('photo_description', null, $options = array('size'=>'50x5', 'class' => 'form-control')) }}
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6">
			{{ Form::submit(Lang::get('gallery.submit'), array('class' => 'btn')) }}
		</div>
	</div>

{{ Form::close() }}