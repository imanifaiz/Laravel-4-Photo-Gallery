<?php

class EloquentBaseRepository {

	/**
	 * The model
	 * @var Eloquent
	 */
	protected $model;

	/**
	 * Create new instance of EloquentBaseRepository
	 * @param EloquentBaseModel $model 
	 */
	public function __construct(EloquentBaseModel $model)
	{
		$this->model = $model;
	}

	/**
	 * Model getter
	 * @return Eloquent 
	 */
	public function getModel()
	{
		return $this->model;
	}

	/**
	 * Model setter
	 * @param EloquentBaseModel $model 
	 */
	public function setModel(EloquentBaseModel $model)
	{
		$this->model = $model;
	}

	/**
	 * Get all records (active records only)
	 * @return Eloquent 
	 */
	public function getAll()
	{
		return $this->model->all();
	}

	/**
	 * Get only deleted records
	 * @return Eloquent 
	 */
	public function getAllTrashed()
	{
		return $this->model->onlyTrashed()->get();
	}

	/**
	 * Get all records with pagination
	 * @param  int $count 
	 * @return Eloquent        
	 */
	public function getAllPaginated($count)
	{
		return $this->model->paginate($count);
	}

	/**
	 * Get record by ID
	 * @param  int $id 
	 * @return Eloquent     
	 */
	public function getById($id)
	{
		return $this->model->find($id);
	}

	/**
	 * Get record by ID even if it is trashed
	 * @param  int $id 
	 * @return Eloquent     
	 */
	public function getByIdWithTrashed($id)
	{
		return $this->model->withTrashed()->find($id);
	}

	/**
	 * Get the model by the ID passed in
	 * @param  int $id 
	 * @return Eloquent     
	 */
	public function requiredById($id)
	{
		$model = $this->model->find($id);

		if (!$model) {
			throw new EntityNotFoundException;
		}

		return $model;
	}

	/**
	 * Create new instance of the given model
	 * @param  array  $attributes 
	 * @return Eloquent             
	 */
	public function getNew($attributes = array())
	{
		return $this->model->newInstance($attributes);
	}

	/**
	 * Store the data that passed in
	 * @param  mixed $data 
	 * @return void       
	 */
	public function store($data)
	{
		if ($data instanceOf Eloquent) {
			$this->storeEloquentModel($data);
		} elseif (is_array($data)) {
			$this->storeArray($data);
		}
	}

	/**
	 * Delete the model that passed in
	 * @param  Eloquent $model 
	 * @return void        
	 */
	public function delete($model)
	{	
		// dd($model->toJson());
		$model->delete();
	}

	/**
	 * Store the Eloquent model that passed in
	 * @param  Eloquent $model 
	 * @return void        
	 */
	public function storeEloquentModel($model)
	{
		if ($model->getDirty()) {
			$model->save();
		} else {
			$model->touch();
		}
	}

	/**
	 * Store an array of data
	 * @param  array $data 
	 * @return void 
	 */
	public function storeArray($data)
	{
		$model = $this->getNew($data);

		$this->storeEloquentModel($model);
	}
}