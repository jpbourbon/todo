<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'summary',
        'priority',
        'completed',
        'expires_at'
    ];

    /**
     * The table name
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * allow / disallow timestamps.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Validation Rules for the model.
     *
     * @return array
     */
    public function validationRules()
    {
        return [
            'title' => 'string|required',
            'summary' => 'string',
            'priority' => 'boolean',
            'completed' => 'boolean',
            'expires_at' => 'timestamp',
        ];
    }

    public function validationMessages()
    {
        return [
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'summary.string' => 'Summary must be a string',
            'priority.boolean' => 'Priority must be a boolean',
            'completed.boolean' => 'Completed must be a boolean',
            'expires_at.timestamp' => 'Expiration must be a valid date',
        ];
    }
}
