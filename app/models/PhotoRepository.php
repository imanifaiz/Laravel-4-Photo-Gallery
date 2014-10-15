<?php

class PhotoRepository extends EloquentBaseRepository implements PhotoInterface {

	public function __construct(Photo $photo)
	{
		$this->model = $photo;
	}

	/**
	 * Get all records (active records only)
	 * @return Eloquent 
	 */
	public function getAll()
	{
		return $this->model->orderBy('order_seq');
	}
}