<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'preguntas';

    /**
     * Hidden fields
     */
    protected $hidden = [
        'enunciado',
        'comentarios',
    ];

    /**
     * Relationship with BlockQuestion
     */
    public function blocks()
    {
        return $this->hasMany(BlockQuestion::class, 'preguntaID');
    }

    /**
     * Relationship with TestQuestion
     */
    public function tests()
    {
        return $this->hasMany(TestQuestion::class, 'preguntaID');
    }

    /**
     * Relationship with QuestionStatus
     */
    public function status()
    {
        return $this->belongsTo(QuestionStatus::class);
    }

    /**
     * Format name fields
     */
    public function newQuery()
    {
        $query = parent::newQuery();

        $query->select(
            '*',
            'enunciado as enunciated',
            'comentarios as commentary',
        );

        return $query;
    }
}