<?php

class GalleryController extends BaseController {

	/**
	 * The album model
	 * @var  album
	 */
	protected $album;

	/**
	 * The photo model
	 * @var  Photo 
	 */
	protected $photo;

	/**
	 * Instantiate the controller
	 * @param Album $album 
	 * @param Photo $photo 
	 */
	public function __construct(AlbumInterface $album, PhotoInterface $photo)
	{
		$this->album = $album;

		$this->photo = $photo;
	}

	/* ====================================================
	 * Method for Showing
	 * ==================================================== */

	/**
	 * Get all albums
	 * @return Illuminate\View\View
	 */
	public function getIndex()
	{
		$albums = $this->album->getAll();

		$this->layout->content = View::make('index', compact('albums'));
	}

	/**
	 * View album photos
	 * @param  int $id 
	 * @return Illuminate\View\View     
	 */
	public function getAlbum($id)
	{
		$album = $this->album->getById($id);

		$albumPhotos = $album->photos()->paginate(10);

		$this->layout->content = View::make('album', compact('album', 'albumPhotos'));
	}

	/**
	 * View a single photo
	 * @param  int $id 
	 * @return Illuminate\View\View
	 */
	public function getPhoto($id)
	{
		$photo = $this->photo->getById($id);

		$this->layout->content = View::make('photo', compact('photo'));
	}

	/**
	 * Showing the form for creating an album or photo
	 * @param  string $type 'photo' or 'album'
	 * @return Illuminate\View\View
	 */
	public function getNew($type = 'photo', $album_id = null)
	{
		if ($type == 'album') {
			$data = array('type' => 'album');

			$this->layout->content = View::make('new', $data)
									 	   ->nest('form', 'forms.new-album');

		} elseif ($type == 'photo') {
			// If album_id passed in, user cannot select album
			if (isset($album_id) and !empty($album_id)) {
				$album = $this->album->getById($album_id);

				$dropdown[$album_id] = $album['album_name'];

			} else {
				$albumArray = $this->album->getAll()->toArray();

				$dropdown[0] = 'Select Album';

				if (empty($albumArray)) {
					$dropdown[0] = 'Select Album';
				}

				foreach ($albumArray as $album) {
					$dropdown[$album['album_id']] = $album['album_name'];
				}
			}
			
			$data = array('type' => 'photo', 'dropdown' => $dropdown);

			$this->layout->content = View::make('new', $data)
									 	   ->nest('form', 'forms.new-photo', $data);
		}
	}

	/**
	 * Showing the form for editing an album or photo
	 *
	 * @param string $type Either 'album' or 'photo'
	 * @param int $id Id of the album or photo
	 * @return \Illuminate\View\View
	 **/
	public function getEdit($type = 'photo', $id)
	{
		if ($type == 'album') {
			$album = $this->album->getById($id);

			if (is_null($id)) {
				return Redirect::to('/');
			}

			$data = array('type' => 'album', 'album' => $album);

			$this->layout->content = View::make('edit', $data)
									 	   ->nest('form', 'forms.edit-album', $data);
									 	   
		} elseif ($type == 'photo') {
			$photo = $this->photo->getById($id);

			if (is_null($id)) {
				return Redirect::to('/');
			}

			$albumArray = $this->album->getAll()->toArray();

			$dropdown[0] = '';

			if (empty($albumArray)) {
				$dropdown[0] = 'Select Album';
			}

			foreach ($albumArray as $album) {
				$dropdown[$album['album_id']] = $album['album_name'];
			}

			$data = array('type' => 'photo', 'dropdown' => $dropdown, 'photo' => $photo);

			$this->layout->content = View::make('edit', $data)
									 	   ->nest('form', 'forms.edit-photo', $data);
		}
	}
	/* ====================================================
	 * Method for Creating
	 * ==================================================== */

	/**
	 * Adding an album
	 *
	 * @return \Illuminate\View\View
	 **/
	public function postAlbum()
	{
		$record = $this->album->getNew(Input::all());

		if($record->isValid())
		{
			$filename = str_random(4) . '_cover_' . str_replace(' ', '_', Input::get('album_name'));

			$destination = "/uploads/cover_photos/";
			// $upload = Input::file('cover_photo_path')->move(public_path() . $destination, $filename);

			// Create thumbnail using image intervention
			// open an image file
			$img = Image::make(Input::file('cover_photo_path')->getRealPath());
			// resize the instance
			$img->fit(255, 255);
			// save the thumbnail image
			$img->save(Input::file('cover_photo_path')->getRealPath(), 80);

			$upload = Input::file('cover_photo_path')->move(public_path() . $destination, $filename);

			if( $upload == false )
			{
				return Redirect::to('new/album')
       							->withInput()
       							->withErrors($record->getErrors())
       							->with('message', 'There were some errors');
			}

			$newAlbum = array();

			$newAlbum['album_name'] = Input::get('album_name');
			$newAlbum['album_description'] = Input::get('album_description');
			$newAlbum['cover_photo_path'] = $filename;

			$this->album->store($newAlbum);

			return Redirect::to('/');
		}
		else
		{
			return Redirect::to('new/album')
            				->withInput()
            				->withErrors($record->getErrors())
            				->with('message', 'There were some errors');
		}
	}

	/**
	 * Adding an photo
	 *
	 * @return \Illuminate\View\View
	 **/
	public function postPhoto()
	{	
		$record = $this->photo->getNew(Input::all());

		if($record->isValid())
		{
			$filename = str_random(4) . '_' . Input::file('photo_path')->getClientOriginalName();
			$destination = "/uploads/photos/";
			$upload = Input::file('photo_path')->move(public_path() . $destination, $filename);

			if( $upload == false )
			{
				return Redirect::to('new/photo')
       							 ->withInput()
       							 ->withErrors($record->getErrors())
       							 ->with('message', 'There were some errors');
			}

			// Create thumbnail using image intervention
			// open an image file
			$img = Image::make(public_path() . $destination . $filename);
			// resize the instance
			$img->fit(255, 255);
			// save the thumbnail image
			$img->save(public_path() . "/uploads/thumbnail_photos/$filename");

			$newPhoto = array();

			$newPhoto['photo_name'] = Input::get('photo_name');
			$newPhoto['photo_description'] = Input::get('photo_description');
			$newPhoto['photo_path'] = $filename;
			$newPhoto['album_id'] = Input::get('album_id');

			$this->photo->store($newPhoto);

			return Redirect::to('album/' . Input::get('album_id'));
		}

		return Redirect::to('new/photo')
       					 ->withInput()
       					 ->withErrors($record->getErrors())
       					 ->with('message', 'There were some errors');
	}

	/* ====================================================
	 * Method for Editing
	 * ==================================================== */

	/**
	 * Updating an album
	 *
	 * @param int $id Id of the album
	 * @return \Illuminate\View\View
	 **/
	public function putAlbum($id)
	{
		$input = Input::except('_method');

        $validator = Validator::make($input,$this->album->validationRules);

        if ($validator->passes())
        {
            $album = $this->album->find($id);
            $album->update($input);

            return Redirect::to('album/' . $id);
        }
        else
        {
        	return Redirect::to('edit/album/' . $id)
            				 ->withInput()
            				 ->withErrors($validator)
            				 ->with('message', 'There were some errors');
        }
	}

	/**
	 * Updating a photo
	 *
	 * @param int $id Id of the photo
	 * @return \Illuminate\View\View
	 **/
	public function putPhoto($id)
	{
		$input = Input::except('_method');

        $validator = Validator::make($input,$this->photo->validationRules);

        if ($validator->passes())
        {
            $photo = $this->photo->find($id);
            $photo->update($input);

            return Redirect::to('photo/' . $id);
        }
        else
        {
        	return Redirect::to('edit/photo/' . $id)
            				 ->withInput()
            				 ->withErrors($validator)
            				 ->with('message', 'There were some errors');
        }
	}

	/* ====================================================
	 * Method for Deleting
	 * ==================================================== */

	/**
	 * Deleting an album
	 *
	 * @param int $id Id of the album
	 * @return \Illuminate\View\View
	 **/
	public function deleteAlbum ($id)
	{
		$album = $this->album->getById($id);

		$albumPhotos = $album->photos;
		
		foreach ($albumPhotos as $photo) {
			$this->deletePhoto($photo->photo_id);
		}

		$this->album->delete($album);

		return Redirect::to('/');
	}

	/**
	 * Deleting a photo
	 *
	 * @param int $id Id of the photo
	 * @return \Illuminate\View\View
	 **/
	public function deletePhoto ($id)
	{
		$photo = $this->photo->getById($id);

		$album = $photo->album_id;

        $file = public_path() . "/uploads/photos/" . $photo->photo_path;
        $thumbnail = public_path() . "/uploads/thumbnail_photos/" . $photo->photo_path;
        
        unlink($file);
        unlink($thumbnail);

        $this->album->delete($photo);

        return Redirect::to("album/$album");
	}
}