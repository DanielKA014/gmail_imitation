<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class compose extends Model
{
    public function user(){
    return $this->belongTo(User::class);
}

}
