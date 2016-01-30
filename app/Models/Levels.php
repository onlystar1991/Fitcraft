<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Levels extends Model {

    protected $table = 'levels';
    protected $fillable = ['level', 'xp_second', 'xp_hour','xp_hour', 'xp_required', 'xp_objective', 'xp_rival', 'xp_tournament', 'hours_required', 'columative', 'hours'];

    public function maxLevel()
    {
        return Cache::get('levels_max_level', function() {
            return parent::max('level');
        });
    }
}
