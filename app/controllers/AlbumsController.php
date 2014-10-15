<?php 

class AlbumsController extends BaseController {

	public function getList()
	{
		$albums = Album::with('photos')->get();

		return View::make('index', compact('albums'));
	}

	public function getAlbum($id)
	{
		// $album = Album::find($id);
		$album = Album::with('photos')->find($id);

		$albums = Album::all();

		return View::make('album', compact('album', 'albums'));
	}

	public function getForm()
	{
		return View::make('createalbum');
	}

	public function postCreate()
	{
		$rules = array(
			'name' => 'required',
			'cover_image' => 'required|image'
		);

		$data = Input::all();

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) {
			return Redirect::route('create_album_form')
							 ->withErrors($validator)
							 ->withInput();
		}

		$file = Input::file('cover_image');

		$random_name = str_random(8);

		$destinationPath = public_path() . '/albums';

		$extension = $file->getClientOriginalExtension();

		$filename = $random_name . '_cover.' . $extension;

		$uploadSuccess = Input::file('cover_image')
						 ->move($destinationPath, $filename);

		$album = Album::create(array(
			'name' => Input::get('name'),
			'description' => Input::get('description'),
			'cover_image' => $filename
		));

		return Redirect::route('show_album', array('id' => $album->id));
	}

	public function getDelete($id)
	{
		$album = Album::find($id);

		$album->delete();

		return Redirect::route('index');
	}
}