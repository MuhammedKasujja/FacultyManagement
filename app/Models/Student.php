<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    public function course() {
        return $this->belongsTo(Course::class); 
    }

    public static function boot()
    {

        parent::boot();

        static::creating(function ($model) {

            $unique_id = "0000000";

            $unique_id .= isset($model->attributes['id']) ? $model->attributes['id'] : rand();;

            $model->attributes['student_no'] = "S-" . Helper::routefreestring($unique_id);
        });

        static::created(function ($model) {

            $unique_id = "0000000";

            $unique_id .= isset($model->attributes['id']) ? $model->attributes['id'] : rand();;

            $model->attributes['student_no'] = "S-" . Helper::routefreestring($unique_id);

            $model->save();
        });
    }
}
