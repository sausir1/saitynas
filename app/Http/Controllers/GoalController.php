<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoalRequest;
use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index()
    {
        $goals = request()->user()->goals;
        return response()->json($goals, 200);
    }

    public function show($id)
    {
        $goal = Goal::where('user_id', request()->user()->id)
            ->where('id', $id)->firstOrFail();
        return response()->json($goal);
    }

    public function store(GoalRequest $request)
    {
        $validated = $request->validated();
        $goal = Goal::create($validated);
        return response()->json($goal, 201);
    }

    public function update(Goal $goal, GoalRequest $request)
    {
        $validated = $request->validated();
        $goal->updateOrFail($validated);
        return response()->json($goal);
    }

    public function destroy($id)
    {
        $goal = Goal::where('user_id', request()->user()->id)
            ->where('id', $id)->firstOrFail();
        $goal->deleteOrFail();
        return response()->json($goal, 202);
    }
}
