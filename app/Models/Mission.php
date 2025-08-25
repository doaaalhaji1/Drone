<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    protected $fillable = [
        'disaster_report_id','assigned_by','status','stream_url','started_at','ended_at','notes'
    ];

    protected $casts = [
        'started_at'=>'datetime','ended_at'=>'datetime',
    ];

    public function report(){ return $this->belongsTo(DisasterReport::class,'disaster_report_id'); }
    public function updates(){ return $this->hasMany(MissionUpdate::class); }
    public function admin(){ return $this->belongsTo(User::class,'assigned_by'); }
}
