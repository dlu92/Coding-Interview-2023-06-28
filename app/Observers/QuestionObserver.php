<?php

namespace App\Observers;

use App\Models\Question;
use App\Models\QuestionStatusHistory;

class QuestionObserver
{
    private const SESSION_KEY = 'audit_question_observer';

    protected $session;
    
    public function __construct()
    {
        $this->session = app('session');;
    }

    /**
     * Listen to the Question updating event.
     * 
     */
    public function updating(Question $question): void
    {
        $questionOrigin = $question->getOriginal();
        $audit          = new QuestionStatusHistory([
            'question_id'   => $questionOrigin['id'],
            'status_id'     => $questionOrigin['status_id'],
            'created_at'    => $questionOrigin['updated_at'],
        ]);

        $this->session->put(self::SESSION_KEY."_update_{$question->id}", $audit);
    }

    /**
     * Listen to the Question updated event.
     * 
     */
    public function updated(Question $question): void
    {
        $audit = $this->session->get(self::SESSION_KEY."_update_{$question->id}");

        if ($audit) {
            $audit->save();
        }
    }

}