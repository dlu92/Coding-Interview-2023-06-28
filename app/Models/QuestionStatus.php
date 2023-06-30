<?php

namespace App\Models;

use App\Models\Question as ModelsQuestion;
use Illuminate\Database\Eloquent\Model;

class QuestionStatus extends Model
{
    const PUBLISHED = 1;
    const EXPIRED   = 2;
    const REPEALED  = 3;
    const OBSOLETE  = 4;

    const PUBLISHED_ALIAS = 'PUBLISHED';
    const EXPIRED_ALIAS   = 'EXPIRED';
    const REPEALED_ALIAS  = 'REPEALED';
    const OBSOLETE_ALIAS  = 'OBSOLETE';

    public $timestamps = false;

    /**
     * Relationship with BlockQuestion
     */
    public function questions()
    {
        return $this->hasMany(ModelsQuestion::class, 'status_id');
    }
}