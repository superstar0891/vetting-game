<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $fillable = [
        'sport_id',
        'game_id',
        'timezone',
        'timestamp',
        'time',
        'name',
        'date_time',
        'league_id',
        'home_team_id',
        'away_team_id',
    ];
}
