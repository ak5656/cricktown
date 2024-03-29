<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreCard extends Model
{
    use HasFactory;
    protected $fillable = ['match_id', 'api_name', 'called', 'json'];
}
