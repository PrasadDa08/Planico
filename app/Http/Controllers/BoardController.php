<?php

namespace App\Http\Controllers;

use App\Http\Requests\Board\StoreBoardRequest;
use App\Http\Requests\Board\UpdateBoardRequest;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $board = Board::get();

        return response()->json([
            'message' => 'Listed all boards',
            'boards' => $board->load('owner'),
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
    public function store(StoreBoardRequest $request)
    {
        $board = Board::create([
            'owner_id' => auth('sanctum')->id(),
            'name' => $request->name,
            'description' => $request->description,
            'is_private' => $request->is_private ?? false
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Board Created Successfully',
            'board' => $board->load('owner')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board)
    {
        return response()->json([
            'messages' => 'Listed a board',
            'board' => $board->load('owner')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBoardRequest $request, Board $board)
    {
        $board->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Board details updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board)
    {
        $board->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Board Deleted Successfully',
        ]);
    }
}
