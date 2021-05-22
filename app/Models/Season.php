<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    public function resorts()
    {
        return $this->belongsToMany(Resort::class, 'season_resort', 'season_id', 'resort_id');
    }

    public function hasResort()
    {
        
    }

    public function assignResort($resort)
    {
        if (is_object($resort)) {
            $resort = $resort->getKey();
        }

        if (is_array($resort)) {
            if(!isset($resort['id'])) {
                return $this->assignResorts($resort);
            }

            $resort = $resort['id'];
        }

        $this->resorts()->attach($resort);
    }

    public function assignResorts($resorts)
    {
        foreach ($resorts as $resort) {
            $this->assignResort($resort);
        }
    }

    public function removeResort($resort)
    {
        if (is_object($resort)) {
            $resort = $resort->getKey();
        }
        if (is_array($resort)) {
            if(!isset($resort['id'])) {
                return $this->removeResorts($resort);
            }

            $resort = $resort['id'];
        }

        $this->resorts()->detach($resort);
    }

    public function removeResorts($resorts = null)
    {
        if (!$resorts) $resorts = $this->resorts()->get();
        foreach ($resorts as $resort) {
            $this->removeResort($resort);
        }
    }
}