<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'preguntas_config_tests';

    /**
     * Hidden fields
     */
    protected $hidden = [
        'test_tipoID',
        'nombre',
    ];

    /**
     * Relationship with TestQuestion
     */
    public function questions()
    {
        return $this->hasMany(TestQuestion::class, 'testID');
    }

    /**
     * Format name fields
     */
    public function newQuery()
    {
        $query = parent::newQuery();

        $query->select(
            '*',
            'nombre as name',
            'test_tipoID as type_id'
        );

        return $query;
    }
}