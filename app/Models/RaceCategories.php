<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaceCategories extends Model {

    protected $table = 'race_categories';

    protected $fillable = ['title','level'];
}



