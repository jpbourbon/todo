<?php

namespace App\Http\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskRepository
{
    /**
     * Retrieves all tasks
     *
     * @return array
     */
    public static function retrieve()
    {
        $tasks = Task::all()->sortByDesc('id');
        
        if (!$tasks) {
            return false;
        }

        return $tasks->toArray();
    }

    /**
     * Creates a new task
     *
     * @var object
     * @return mixed
     */
    public static function create($data)
    {
        $task = new Task();
        
        $task->title = $data->title;

        if (property_exists($data, 'summary')) {
            $task->summary = $data->summary;
        }
        if (property_exists($data, 'priority')) {
            $task->priority = $data->priority;
        }
        if (property_exists($data, 'expires_at')) {
            $task->expires_at = $data->expires_at;
        }

        if (!$task->save()) {
            return false;
        }

        return $task->id;
    }

    /**
     * Updates a task
     *
     * @var object
     * @return bool
     */
    public static function update($data)
    {
        $task = Task::where('id',(int) $data->id)->firstOrFail();
        
        if (property_exists($data, 'title')) {
            $task->title = $data->title;
        }

        if (property_exists($data, 'summary')) {
            $task->summary = $data->summary;
        }
        if (property_exists($data, 'priority')) {
            $task->priority = $data->priority;
        }
        if (property_exists($data, 'completed')) {
            $task->completed = $data->completed;
        }
        if (property_exists($data, 'expires_at')) {
            $task->expires_at = $data->expires_at;
        }

        if (!$task->save()) {
            return false;
        }

        return true;
    }

    /**
     * Deletes a task
     *
     * @var object
     * @return bool
     */
    public static function delete($data)
    {
        $task = Task::where('id', $data->id)->firstOrFail();
        
        if (!$task->delete()) {
            return false;
        }

        return true;
    }
}
