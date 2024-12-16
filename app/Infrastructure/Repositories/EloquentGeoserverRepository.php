<?php

namespace App\Infrastructure\Repositories;
use App\Models\WmsData;

class WmsRepository
{
    public function saveWmsData($data)
    {
        return WmsData::create($data);
    }
}