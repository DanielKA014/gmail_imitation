<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    public function user(){
    return $this->belongTo(User::class);
}

}
