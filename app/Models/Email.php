<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    public function user(){
    return $this->belongTo(User::class);
}
protected $fillable = ['from', 'to', 'subject', 'body', 'file_path', 'is_draft'];

}
