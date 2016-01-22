<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Levels extends Model {

    protected $table = 'levels';

    public function maxLevel()
    {
        return Cache::get('levels_max_level', function() {
            return parent::max('level');
        });
    }
}
