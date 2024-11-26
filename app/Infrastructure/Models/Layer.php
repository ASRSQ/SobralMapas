<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Infrastructure\Models\subcategory;

class Layer extends Model
{
    use HasFactory;

    // Defina a tabela (caso o nome da tabela não siga a convenção)
    protected $table = 'layers';

    // Defina os campos que podem ser preenchidos em massa
    protected $fillable = [
        'name',
        'layer_name',
        'crs',
        'legend_url',
        'type',
        'description',
        'order',
        'subcategory', // Chave estrangeira para a subcategoria
        'image_path',
        'max_scale',
        'symbol'
    ];

    // Defina os campos que são datetimes
    protected $dates = ['created_at', 'updated_at'];

    // Relacionamento com Subcategory
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory');
    }
}
