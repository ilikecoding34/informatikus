<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'col_count',
        'col_comment',
        'col_post',
        'col_related',
        'show_left_column',
        'show_right_column',
        'left_sidebar',
        'right_sidebar',
    ];

    protected $casts = [
        'show_left_column' => 'boolean',
        'show_right_column' => 'boolean',
    ];

}
