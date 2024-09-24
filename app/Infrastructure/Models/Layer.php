<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Infrastructure\Models\Category;
use App\Infrastructure\Models\subcategory;

class Layer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'layer', 'description', 'subcategory_id'];

    public function category()
    {
        return $this->subcategory(Category::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
