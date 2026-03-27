<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreListRequest;
use App\Models\Board;
use App\Models\TaskList;
use Illuminate\Http\Request;

class TaskListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Board $board)
    {
        $this->authorize('viewList', $board);
        $lists = TaskList::where('board_id', $board->id)->get();

        return response()->json([
            'status' => true,
            'message' => 'All Lists for board : ' . $board->name,
            'data' => $lists
        ], 200);
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
    public function store(StoreListRequest $request, Board $board)
    {
        $this->authorize('addList', $board);
        TaskList::create([
            'board_id' => $board->id,
            'name' => $request->name,
            'position' => $request->position
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Task List added successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board,TaskList $list)
    {
        $this->authorize('viewList', $board);
        return response()->json([
            'status' => true,
            'message' => 'list is shown below',
            'list' => $list
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskList $taskList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Board $board, TaskList $list)
    {
        $this->authorize('updateList', $board);
        $list->update([
            'name' => $request->name,
            'position' => $request->position
        ]);

        return response()->json([
            'status' => true,
            'message' => 'List updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board, TaskList $list)
    {
        $this->authorize('deleteList', $board);
        $list->delete();

        return response()->json([
            'status' => true,
            'message' => 'List deleted successfully'
        ]);
    }
}
