<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    
    use HasFactory;

    protected $fillable =[
        'name'
    ];

    public static function boot()
    {

        parent::boot();

        static::creating(function ($model) {

            $unique_id = "0000";

            $unique_id .= isset($model->attributes['id']) ? $model->attributes['id'] : rand();;

            $model->attributes['code'] = "C-" . Helper::routefreestring($unique_id);
        });

        static::created(function ($model) {

            $unique_id = "0000";

            $unique_id .= isset($model->attributes['id']) ? $model->attributes['id'] : rand();;

            $model->attributes['code'] = "C-" . Helper::routefreestring($unique_id);

            $model->save();
        });
    }
}
