<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskStatusUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'status',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
