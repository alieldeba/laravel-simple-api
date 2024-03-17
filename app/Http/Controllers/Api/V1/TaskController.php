<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = new TaskCollection(Task::all());

        if ($tasks->count() < 1) {
            return response()->json(['err' => 'Tasks not found'], 404);
        }

        return $tasks;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());

        return new TaskCollection([$task]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskCollection([$task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->updateOrFail($request->only(['name', 'isCompleted']));

        return response()->json(['message' => 'Task updated 🔥']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->deleteOrFail();

        return response()->json(['message' => 'Task deleted 🔥']);
    }
}
