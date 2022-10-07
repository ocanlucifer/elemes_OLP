<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
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

    public function course()
    {
        return $this->belongsToMany(Course::class);
    }
}
