<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $table = "tournaments";

    protected $fillable = [
        'owner_id',
        'name',
        'logo',
        'gender',
        'stadium',
        'address',
        'tournament_type_id',
        'number_club',
        'number_player',
        'number_group',
        'number_knockout',
        'number_round',
        'score_win',
        'score_draw',
        'score_lose',
        'register_permission',
        'register_date',
        'status',
        'slug',
    ];

    // Tournament n-1 User
    public function user(){
        return $this->belongsTo('App\User', 'owner_id');
    }
}
