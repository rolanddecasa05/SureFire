<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $table="todos";

    protected $fillable = ['id', 'user_id', 'title', 'completed'];
}
