<?php

namespace App\Models;

use Zeero\Database\ORM\Model;

class User extends Model
{

	protected $attributes = ['uuid', 'name', 'password', 'online', 'level', 'created_at', 'login_at', 'updated_at'];
	protected $primary_key = 'uuid'; 
}
