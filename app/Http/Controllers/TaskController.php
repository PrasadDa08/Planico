<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\TaskList;
use App\Models\Board;
use App\Services\ActivityService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Board $board, TaskList $list)
    {
        $this->authorize('viewTask', $board);
        $tasks = Task::where('board_id', $board->id)->where('list_id', $list->id)->get();

        return response()->json([
            'status' => true,
            'message' => 'below are all tasks of list :' . $list->name,
            'data' => TaskResource::collection($tasks->load('createdBy', 'assignedTo'))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request, Board $board, TaskList $list)
    {
        $this->authorize('addTask', $board);
        $task = Task::create([
            'list_id' => $list->id,
            'board_id' => $board->id,
            'assigned_to' => $request->assigned_to,
            'created_by' => auth('sanctum')->id(),
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority ?? 'medium',
            'due_date' => $request->due_date,
            'position' => $request->position
        ]);

        ActivityService::log(
            boardId: $board->id,
            taskId: $task->id,
            action: 'task_added',
            subjectModel: 'Task',
            subjectId: $task->id
        );

        return response()->json([
            'status' => true,
            'message' => 'Task added successfully',
            'data' => new TaskResource($task->load('createdBy', 'assignedTo'))
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board, TaskList $list, Task $task)
    {
        $this->authorize('viewTask', $board);

        return response()->json([
            'status' => true,
            'message' => 'your task listed here',
            'data' => new TaskResource($task->load('createdBy', 'assignedTo'))
        ]);
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
    public function update(UpdateTaskRequest $request, Board $board, TaskList $list, Task $task)
    {
        $this->authorize('updateTask', $board);
        $task->update($request->validated());

        ActivityService::log(
            boardId: $board->id,
            taskId: $task->id,
            action: 'task_updated',
            subjectModel: 'Task',
            subjectId: $task->id
        );

        return response()->json([
            'status' => true,
            'message' => 'Task updated successfuly',
            'data' => new TaskResource($task->fresh()->load('createdBy', 'assignedTo'))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board, TaskList $list, Task $task)
    {
        $this->authorize('deleteTask', $board);

        ActivityService::log(
            boardId: $board->id,
            taskId: $task->id,
            action: 'task_deleted',
            subjectModel: 'Task',
            subjectId: $task->id
        );

        $task->delete();


        return response()->json([
            'status' => true,
            'message' => 'Task deleted successfully'
        ]);
    }

    public function boardTasks(Board $board)
    {
        $this->authorize('viewTask', $board);

        $tasks = Task::where('board_id', $board->id)->with('assignedTo', 'createdBy', 'list')->orderBy('list_id')->orderBy('position')->get();

        return response()->json([
            'status' => true,
            'message' => 'All tasks for Board : ' . $board->name,
            'data' => TaskResource::collection($tasks)
        ]);
    }
}
