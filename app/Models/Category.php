<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function parent(){
        return $this->belongsTo(Department::class, 'id', 'parent_id');
    }

    public function products(){
        return $this->hasMany(Project::class);
    }
}
