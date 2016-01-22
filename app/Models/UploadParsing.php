<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadParsing extends Model {

	protected $table = 'upload_parsings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['file_id', 'user_id', 'total_count', 'completed_count', 'completed_all'];

    /**
     * @param $fields
     * @return Files
     */
    public static function add($fields)
    {
        $model = new UploadParsing();
        foreach ($fields as $key=>$value) {
            $model->$key = $value;
        }
        $model->save();
        return $model;
    }

    /**
     * @param $where
     * @return mixed
     */
    public static function getWhere($where)
    {
        return parent::where($where)
            ->get();
    }

    /**
     * @param $where
     * @return mixed
     */
    public static function getFirst($where)
    {
        return parent::where($where)
            ->first();
    }

}
