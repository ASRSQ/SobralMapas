<?php

namespace App\Infrastructure\Models;

use App\Infrastructure\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function layers()
    {
        return $this->hasMany(Layer::class);
    }
}
