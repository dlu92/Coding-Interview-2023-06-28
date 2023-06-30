<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockQuestion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'preguntas_bloque';

    /**
     * Hidden fields
     */
    protected $hidden = [
        'oposicionID',
        'preguntaID',
        'bloqueID',
    ];

    /**
     * Relationship with Question
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'preguntaID');
    }

    /**
     * Format name fields
     */
    public function newQuery()
    {
        $query = parent::newQuery();

        $query->select(
            '*',
            'oposicionID as oposition_id',
            'preguntaID as question_id',
            'bloqueID as block_id'
        );

        return $query;
    }
}