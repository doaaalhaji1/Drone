<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 

class DisasterReport extends Model
{
    protected $fillable = [
        'user_id','type','severity','title','description','lat','lng','address','status'
    ];

    protected $casts = [
        'lat'=>'float','lng'=>'float',
    ];

     public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function attachments(){ return $this->morphMany(Attachment::class,'attachable'); }
    public function mission(){ return $this->hasOne(Mission::class); }
}
