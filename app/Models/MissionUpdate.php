<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionUpdate extends Model
{
    protected $fillable = [
        'mission_id','lat','lng','battery','altitude','speed','photo_path','video_clip','message'
    ];

    protected $casts = [
        'lat'=>'float','lng'=>'float','battery'=>'float','altitude'=>'float','speed'=>'float',
    ];

    public function mission(){ return $this->belongsTo(Mission::class); }
}
