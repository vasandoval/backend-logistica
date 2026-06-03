<?php
namespace App\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $table = 'usuarios';
    public $timestamps = true;
}