<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // To show the tasks under a project
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
