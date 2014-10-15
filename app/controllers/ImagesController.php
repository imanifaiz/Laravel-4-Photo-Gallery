<?php

class ImagesController extends BaseController {

	public function getForm($id)
	{
		$album = Album::find($id);

		return View::make('addimage', compact('album'));
	}

	public function postAdd()
	{
		$rules = array(
			'album_id' => 'required|numeric|exists:albums,id',
			'image' => 'required|image'
		);

		$data = Input::all();

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) {
			return Redirect::route('add_image', array(
				'id' => Input::get('album_id')))
				->withErrors($validator)
				->withInput();
		}

		$file = Input::file('image');

		$random_name = str_random(8);

		$destination_path = public_path() . '/albums';

		$extension = $file->getClientOriginalExtension();

		$filename = $random_name . '_album_image.' . $extension;

		$uploadSuccess = Input::file('image')
						 ->move($destination_path, $filename);

		Image::create(array(
			'description' => Input::get('description'),
			'image' => $filename,
			'album_id' => Input::get('album_id')
		));

		return Redirect::route('show_album', array(
			'id' => Input::get('album_id')));
	}

	public function getDelete($id)
	{
		$image = Image::find($id);

		$image->delete();

		return Redirect::route('show_album', array(
			'id' => $image->album_id));
	}
}