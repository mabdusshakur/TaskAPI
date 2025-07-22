<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::where('user_id', Auth::id());

        // Filter by title
        if($request->has('title')) {
            $query->where('title', 'like', '%'.$request->input('title').'%');
        }

        // Filter by status
        if($request->has('status')){
            $query->where('status', $request->input('status'));
        }

        // Filter by date range
        if($request->has('from_date')){
            $query->where('due_date', '>=', $request->input('from_date'));
        }
        if($request->has('to_date')){
            $query->where('due_date', '<=', $request->input('to_date'));
        }

        // sort by due_date
        $sortDirection = $request->input('sort', 'asc');
        $query->orderBy('due_date', $sortDirection);

        $perPage = $request->input('per_page', 10);
        $tasks = $query->paginate($perPage);

        return response()->json([
            'tasks' => $tasks
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $task = Task::create([
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'due_date' => $request->input('due_date'),
            'status' => $request->input('status', 'pending'),
        ]);

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        return response()->json([
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $task = Task::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $task->update($request->only([
            'title',
            'description',
            'due_date',
            'status',
        ]));

        return response()->json([
            'task' => $task,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ]);
    }
}
