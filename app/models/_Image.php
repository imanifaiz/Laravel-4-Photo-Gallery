<?php

class _Image extends Eloquent {

	protected $table = 'images';

	protected $fillable = ['album_id', 'description', 'image'];
}