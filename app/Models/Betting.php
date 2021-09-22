<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Betting extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'sender_id',
        'receiver_id',
        'wage_id',
        'team_id',
        'odd'
    ];
}
