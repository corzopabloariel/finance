<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Currency;

class Expense extends Eloquent
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
    protected $collection = 'expenses';

    /**
    * @var array
    */
    public const type = [
        1 => 'Normal',
        2 => 'En cuotas',
        3 => 'Todos los meses'
    ];
    /**
     * get type
     */
    public function getTypeAttribute()
    {
        return self::type[$this->attributes['type']];
    }
    
	protected $fillable = [
		'title', 'currency_id', 'category_id', 'value', 'type'
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /* ================== */
    public static function create($attr)
    {
        $model = new self;
        if (isset($attr['title']))
            $model->title = $attr['title'];
        if (isset($attr['currency_id']))
            $model->currency_id = $attr['currency_id'];
        if (isset($attr['category_id']))
            $model->category_id = $attr['category_id'];
        if (isset($attr['value']))
            $model->value = $attr['value'];
        if (isset($attr['type']))
            $model->type = $attr['type'];
        $model->save();

        return $model;
    }
}
