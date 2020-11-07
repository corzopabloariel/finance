<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Eloquent 
{
	use SoftDeletes;
    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $primaryKey = '_id';
	protected $connection = 'mongodb';
	protected $collection = 'currencies';

	protected $fillable = [
		'name', 'code', 'value'
    ];
    
    /* ================== */
    public static function create($attr)
    {
        $model = new self;
        if (isset($attr['name']))
            $model->name = $attr['name'];
        if (isset($attr['code']))
            $model->code = $attr['code'];
        if (isset($attr['value']))
            $model->value = $attr['value'];
        $model->save();

        return $model;
    }

    /* ================== */
    public static function remove($data, Bool $normal) : Bool
    {
        try {
            if (gettype($data) == "string")
                $data = self::find($data);
            if ($normal)
                $data->delete();
            else
                $data->forceDelete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function getAll(String $attr = "_id", String $order = "ASC")
    {
        return self::orderBy($attr, $order)->get();
    }
}
