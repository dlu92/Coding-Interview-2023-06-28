<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionStatusHistory extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'question_id',
        'status_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Relationship with Question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Relationship with QuestionStatus
     */
    public function status()
    {
        return $this->belongsTo(QuestionStatus::class);
    }
}