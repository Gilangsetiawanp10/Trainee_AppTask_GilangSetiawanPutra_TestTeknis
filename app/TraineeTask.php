<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webpatser\Uuid\Uuid;

class TraineeTask extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'trainee_id', 'task', 'desc', 'start_date', 'deadline', 'status'
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'start_date' => 'date',
        'deadline' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    public function trainee()
    {
        return $this->belongsTo(User::class, 'trainee_id');
    }
}
