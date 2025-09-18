<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function categories(){
        return $this->hasMany(Category::class, 'id', 'parent_id');
    }

    public function headingMember(){
        return $this->hasOne(Member::class, 'id', 'heading_member');
    }
}
