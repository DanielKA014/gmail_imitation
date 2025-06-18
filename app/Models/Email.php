<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    public function user(){
    return $this->belongTo(User::class);
}
protected $fillable = ['to','from','subject','body','image_path','is_favorite','is_draft'];

    protected $casts = [
        'is_draft' => 'boolean',
        'is_favorite' => 'boolean',
    ];

    public function scopeFavorites($query)
    {
        return $query->where('is_favorite', true);
    }

    public function scopeDrafts($query)
    {
        return $query->where('is_draft', true);
    }

    public function scopeRegular($query)
    {
        return $query->where('is_draft', false);
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function isFavoritedByUser()
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }
}
