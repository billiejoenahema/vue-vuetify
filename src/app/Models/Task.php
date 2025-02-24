<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Task extends Model
{
    use HasFactory;

    /**
     * 複数代入可能な属性
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'priority',
        'is_done',
    ];

    /**
     * キャストする属性
     *
     * @var array<int, string>
     */
    protected $casts = [
        'is_done' => 'boolean',
    ];

}
