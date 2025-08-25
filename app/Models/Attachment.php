<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['path','kind'];

    public function attachable(){ return $this->morphTo(); }
}
