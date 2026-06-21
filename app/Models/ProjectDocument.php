<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDocument extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'filename',
        'file_path',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
