<?php

namespace App\Http\Controllers;

use App\Http\Requests\BadgeRequest;
use App\Models\Badge;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    public function index()
    {
        $badges = Badge::all();
        return response()->json(compact('badges'), 200);
    }

    public function show(Badge $badge)
    {
        return response()->json(compact('badge'), 200);
    }

    public function getUserBadges()
    {
        $badges = request()->user()->badges;
        return response()->json(compact('badges'));
    }

    public function edit(Badge $badge, BadgeRequest $request)
    {
        $validated = $request->validated();
        $badge->updateOrFail($validated);
        return response()->json(compact('badge'), 200);
    }

    public function create(BadgeRequest $request)
    {
        $validated = $request->validated();
        $badge = Badge::create($validated);
        return response()->json(compact('badge'), 201);
    }

    public function delete(Badge $badge)
    {
        $badge->delete();
        return response()->json(compact('badge'));
    }
}
