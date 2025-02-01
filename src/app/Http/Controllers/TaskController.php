<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Task::query();
        if ($request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
        if ($request->priority) {
            $query->where('priority', $request->priority);
        }
        $tasks = $query->orderby('updated_at', 'desc')->get();

        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->all();

        $task = DB::transaction(static function () use ($data) {
            return Task::create($data);
        });

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): JsonResponse
    {
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): JsonResponse
    {
        $data = $request->all();

        DB::transaction(static function () use ($data, $task) {
            $task->fill($data)->save();
        });

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json(null, 204);
    }
}
