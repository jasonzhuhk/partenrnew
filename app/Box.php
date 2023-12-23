<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    const COLUMN_ID = 'id';
    const COLUMN_NAME = 'name';

    protected $guarded = [self::COLUMN_ID];
}
