<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WmsLayer extends Model
{
    use HasFactory;

    protected $fillable = ['wms_link_id', 'layer_name', 'crs', 'formats', 'description'];

    public function wmsLink()
    {
        return $this->belongsTo(WmsLink::class);
    }
}
