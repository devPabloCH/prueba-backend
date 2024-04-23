<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingReport extends Model
{
    use HasFactory;
    protected $guarded = "id";
    protected $table = "training_reports";
    protected $fillable = [
        'training_id',
        'user_id',
        'distance',
        'evidence',
        'comments'
    ];
    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    public function training(){
        return $this->hasOne(Training::class, 'id', 'training_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getEvidenceAttribute(){
        if($this->attributes['evidence']){
            return url('public/' . $this->attributes['evidence']);
        }
    }
}
