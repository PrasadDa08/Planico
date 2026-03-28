<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Board;
use App\Models\TaskList;
use App\Models\Task;

use Illuminate\Http\Request;


class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Board $board, TaskList $list, Task $task)
    {
        $this->authorize('viewComment', $board);
        $comments = Comment::where('task_id', $task->id)->get();

        return response()->json([
            'status' => true,
            'message' => 'All comments for this task are listed here',
            'data' => $comments
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
    public function store(Request $request, Board $board, TaskList $list, Task $task)
    {
        $this->authorize('addComment', $board);
        $request->validate([
            'body' => 'string|required'
        ]); 

        $comment = Comment::create([
            'task_id' => $task->id,
            'user_id' => auth('sanctum')->id(),
            'body' => $request->body
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Comment added successfully',
            'data' => $comment
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board, TaskList $list, Task $task, Comment $comment)
    {
        $this->authorize('viewComment', $board);
        return response()->json([
            'status' => true,
            'message' => 'Commnt is listed here',
            'data' => $comment->load('user')
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Board $board, TaskList $list, Task $task, Comment $comment)
    {
        $this->authorize('updateComment', [$board, $comment]);
        $request->validate([
            'body' => 'string|required'
        ]);

        $comment->update([
            'body' => $request->body
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Comment updated successfully',
            'data' => $comment->fresh()->load('task', 'user')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board, TaskList $list, Task $task, Comment $comment)
    {
        $this->authorize('deleteComment', [$board, $comment]);
        $comment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }
}
