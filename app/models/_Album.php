<?php

class _Album extends Eloquent {

	protected $table = 'albums';

	protected $fillable = ['name', 'description', 'cover_image'];

	public function photos()
	{
		return $this->hasMany('Image', 'album_id');
	}
}