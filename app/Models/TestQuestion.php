<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'preguntas_tests';

    /**
     * Hidden fields
     */
    protected $hidden = [
        'oposicionID',
        'preguntaID',
        'testID',
    ];

    /**
     * Relationship with Question
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'PreguntaID');
    }

    /**
     * Relationship with Test
     */
    public function test()
    {
        return $this->belongsTo(Test::class, 'TestID');
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
            'testID as test_id'
        );

        return $query;
    }
}