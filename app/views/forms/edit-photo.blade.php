{{ Form::model($photo, array('method' => 'PUT', 'url' => array('photo', $photo->photo_id))) }}
    <ul>
        <li>
            {{ Form::label('photo_name', Lang::get('gallery.name') . ':') }}
            {{ Form::text('photo_name', null, $options = array('size'=>'50')) }}
        </li>

        <li>
            {{ Form::label('photo_path', Lang::get('gallery.path') . ':') }}
            {{ Form::text('photo_path', null, $options = array('size'=>'50')) }}
        </li>

        <li>
            {{ Form::label('album_id', Lang::choice('gallery.album', 1) . ':') }}
            {{ Form::select('album_id', $dropdown) }}
        </li>

        <li>
            {{ Form::label('photo_description', Lang::get('gallery.desc') . ':') }}
            {{ Form::textarea('photo_description', null, $options = array('size'=>'50x5')) }}
        </li>

        <li>
            {{ Form::submit(Lang::get('gallery.submit'), array('class' => 'btn')) }}
            {{ link_to("photo/$photo->photo_id", Lang::get('gallery.cancel'), array('class' => 'btn')) }}
        </li>
    </ul>
{{ Form::close() }}