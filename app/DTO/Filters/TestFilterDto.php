<?php

namespace App\DTO\Filters;

use App\DTO\Dto;

class TestFilterDto extends Dto
{
    protected int $opositionId;
    protected int $typeId;
    protected int $blockId;
    protected bool $published;
}