<?php

class EloquentBaseModel extends Eloquent {

	/**
	 * Validation rules
	 * @var array
	 */
	protected $validationRules = [];

	/**
	 * Validator instance
	 * @var Validator
	 */
	protected $validator;

	/**
	 * Validate data
	 * @param  array   $data 
	 * @return boolean       
	 */
	public function isValid($data = array())
	{
		if (!isset($this->validationRules) or empty($this->validationRules)) {
			throw new NoValidationRulesFoundException('No validation rules found in class ' . get_called_class());
		}

		if (!$data) {
			$data = $this->getAttributes();
		}

		$this->validator = Validator::make($data, $this->getPreparedRules());

		return $this->validator->passes();
	}

	/**
	 * Get errors from the validation
	 * @return Illuminate\Support\MessageBag 
	 */
	public function getErrors()
	{
		return $this->validator->errors();
	}

	/**
	 * Prepare the validation rules
	 * @return array 
	 */
	public function getPreparedRules()
	{
		if (!$this->validationRules) {
			return [];
		}

		$preparedRules = $this->replaceIdsIfExists($this->validationRules);

		return $preparedRules;
	}

	public function replaceIdsIfExists($rules)
	{
		$preparedRules = [];

		foreach ($rules as $key => $rule) {
			if (false !== strpos($rule, '<id>')) {
				if ($this->exists) {
					$rule = str_replace('<id>', $this->getAttribute($this->primaryKey), $rule);
				} else {
					$rule = str_replace('<id>', '', $rule);
				}
			}

			$preparedRules[$key] = $rule;
		}
		
		return $preparedRules;
	}

	/**
	 * Hydrate the model with more stuff and
	 * @return this 
	 */
	public function hydrateRelations() {}

	/**
	 * Delete method overwrite
	 * @return void 
	 */
	public function delete() {
		parent::delete();
	}

	/**
	 * Get the table name
	 * @return string 
	 */
	public function getTableName()
	{
		return $this->table;
	}
}