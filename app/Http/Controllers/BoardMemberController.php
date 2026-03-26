<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Models\BoardMember;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Board $board)
    {
        $members = BoardMember::where('board_id', $board->id)->with('user')->get();

        return response()->json([
            'status' => true,
            'message' => 'listed all members',
            'members' => $members->load('user')
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
    public function store(StoreMemberRequest $request, Board $board)
    {
        $member =BoardMember::create([
            'board_id' => $board->id,
            'user_id' => $request->user_id,
            'role' => $request->role ?? 'member',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Board member added successfully',
            'data' => $member->load('board')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board, BoardMember $member)
    {
        return response()->json([
            'status' => true,
            'message' => 'Boardmember listed here',
            'member' => $member->load('board')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board, BoardMember $boardMemeber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Board $board, BoardMember $member)
    {
        $member->update([
            'role' => $request->role,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Member updated successfully',
            'member' => $member
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board, BoardMember $member)
    {
        $member->delete();

        return response()->json([
            'status' => true,
            'message' => 'Member removed successfully',
        ]);
    }
}
