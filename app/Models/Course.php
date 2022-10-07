<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'description',
        'price',
        'created_by',
        'updated_by'
    ];

    public function user_c()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->withDefault();
    }

    public function user_u()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id')->withDefault();
    }

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }
}
