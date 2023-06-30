<?php

namespace App\DTO\Models;

use App\DTO\Dto;

class QuestionModelDto extends Dto
{
    protected int $id;
    protected int $statusId;
    protected string $enunciated;
    protected string $commentary;
}