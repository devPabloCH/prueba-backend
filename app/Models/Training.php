<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;
    protected $guarded = "id";
    protected $table = "trainings";
    protected $fillable = [
        'name',
        'start_time',
        'recurrence'
    ];
    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    public function trainingReport(){
        return $this->hasMany(TrainingReport::class, 'training_id', 'id');

    }
}
