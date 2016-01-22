<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersTutorial extends Model
{
    protected $table = 'users_tutorial';

    protected $fillable = [];
    protected $casts = [
        'player_card_btn' => 'integer',
        'choose_card_btn' => 'integer',
        'upload_ride_btn' => 'integer',
        'browse_file__btn' => 'integer',
        'upload_file_btn' => 'integer',
        'upload_complete_next' => 'integer',
        'activity_feed_next' => 'integer',
        'athlete_profile_next' => 'integer',
        'leaderboard_next' => 'integer',
        'ride_library_btn' => 'integer',
        'ride_library_next' => 'integer',
        'finish_tooltips_btn' => 'integer',
        'exit_achievements_btn' => 'integer',
        'exit_objectives_btn' => 'integer',
        'exit_gear_btn' => 'integer'
    ];
}
