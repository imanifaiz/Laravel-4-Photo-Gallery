<?php

class Photo extends EloquentBaseModel {

	/**
	 * The table used in this model;
	 * @var string
	 */
	protected $table = 'photos';

	/**
	 * The table primary key
	 * @var string
	 */
	protected $primaryKey = 'photo_id';

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
		'photo_path' => 'image|required',
		'album_id' => 'required|not_in:0',
		'photo_description' => 'max:255'
	);

	/**
	 * Defining the relationship, a photo belongs to an album
	 * @return Album
	 */
	public function album()
	{
		return $this->hasMany('Album');
	}
}