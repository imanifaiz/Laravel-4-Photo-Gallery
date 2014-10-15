{{ Form::model($album, array('method' => 'PUT', 'url' => array('album', $album->album_id))) }}
    <ul>
        <li>
            {{ Form::label('album_name', Lang::get('gallery.name') . ':') }}
            {{ Form::text('album_name', null, $options = array('size'=>'50')) }}
        </li>

        <li>
            {{ Form::label('album_description', Lang::get('gallery.desc') . ':') }}
            {{ Form::text('album_description', null, $options = array('size'=>'30')) }}
        </li>

        <li>
            {{ Form::submit(Lang::get('gallery.submit'), array('class' => 'btn')) }}
            {{ link_to("album/$album->album_id", Lang::get('gallery.cancel'), array('class' => 'btn')) }}
        </li>
    </ul>
{{ Form::close() }}