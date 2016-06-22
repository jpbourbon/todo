<?php

namespace App\Http\Controllers;

use \App\Http\Repositories\TaskRepository;
use Request;
use stdClass;

class TaskController extends Controller
{
	/**
	 * List of tasks
	 *
	 * @var array
	 */
	protected $tasks;

    /**
     * Retrieve function, lists the existing tasks
     *
     * @return array
     */
    public function retrieve()
    {
    	$this->tasks = TaskRepository::retrieve();
        return view('tasks', ['tasks' => $this->tasks]);
    }

    /**
     * Create function
     *
     * @var Request
     * @return mixed
     */
    public function create(Request $request)
    {
        $data = $this->buildObject($request);
        
        if (!TaskRepository::create($data)) {
            return json_encode(false);
        }

        return json_encode(true);
    }

    /**
     * Update function
     *
     * @var Request
     * @return bool
     */
    public function update(Request $request)
    {
    	$data = $this->buildObject($request);
        
        if (!TaskRepository::update($data)) {
            return json_encode(false);
        }

        return json_encode(true);
    }

    /**
     * Delete function
     *
     * @var Request
     * @return bool
     */
    protected function delete(Request $request)
    {
    	$data = $this->buildObject($request);
        
        if (!TaskRepository::delete($data)) {
            return json_encode(false);
        }

        return json_encode(true);
    }

    protected function buildObject($request)
    {
        $object = new stdClass();

        if ($request::has('id')) {
            $object->id = $request::input('id');
        }
        if ($request::has('title')) {
            $object->title = $request::input('title');
        }
        if ($request::has('summary')) {
            $object->summary = $request::input('summary');
        }
        if ($request::has('priority')) {
            if ($request::input('priority') == 1) {
                $object->priority = true;
            } else {
                $object->priority = false;
            }
        }
        if ($request::has('completed')) {
            if ($request::input('completed') == 1) {
                $object->completed = true;
            } else {
                $object->completed = false;
            }
        }
        if ($request::has('date')) {
            if ($request::has('time')) {
                $object->expires_at = $request::input('date').' '.Request::input('time').':00';
            } else {
                $object->expires_at = $request::input('date').' 00:00:00';
            }
        }
        if ($request::has('time')) {
            if (!$request::has('date')) {
                $object->expires_at = date('Y-m-d').' '.$request::input('time').':00';
            }
        }

        return $object;
    }
}
