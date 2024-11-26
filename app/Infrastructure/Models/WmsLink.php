<?php


namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WmsLink extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url'];

    public function layers()
    {
        return $this->hasMany(WmsLayer::class);
    }
}
