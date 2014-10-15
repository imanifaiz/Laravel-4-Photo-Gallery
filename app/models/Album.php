<?php

class Album extends EloquentBaseModel {

	/**
	 * The table used in this model;
	 * @var string
	 */
	protected $table = 'albums';

	/**
	 * The table primary key
	 * @var string
	 */
	protected $primaryKey = 'album_id';

	/**
	 * The fields that are guarded cannot be mass assigned
	 * @var array
	 */
	protected $guarded = array();

	/**
	 * The validation rules
	 * @var array
	 */
	protected $validationRules = array(
		'album_name' => 'required|unique:albums,album_name',
		'album_description' => 'max:255',
		'cover_photo_path' => 'image'
	);

	/**
	 * Defining the relationship, an album could have many photos
	 * @return Photo
	 */
	public function photos()
	{
		return $this->hasMany('Photo');
	}
}