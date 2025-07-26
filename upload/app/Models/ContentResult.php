<?php

namespace App\Models;

use App\Enums\ResultTypes;
use Illuminate\Database\Eloquent\Model;

class ContentResult extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'content_id',
        'summary',
        'citations',
        'type',
    ];

    public function getTypeAttribute($value): string
    {
        return ResultTypes::getText($value);
    }
}
