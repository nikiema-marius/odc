<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'date',
        'heure',
        'lieu',
        'statut',
        'code_qr',
    ];

    public function participants()
    {
        return $this->belongsToMany(Participant::class);
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }
}
