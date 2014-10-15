<?php

class AlbumRepository extends EloquentBaseRepository implements AlbumInterface {

	public function __construct(Album $album)
	{
		$this->model = $album;
	}

	public function getValidationRules()
	{
		return $this->model->validationRules;
	}
}