<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_id',
        'participant_id',
        'date_presence',
    ];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
