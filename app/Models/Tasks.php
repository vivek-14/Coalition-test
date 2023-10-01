<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function projects()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priorities::class, 'priority_id');
    }

}