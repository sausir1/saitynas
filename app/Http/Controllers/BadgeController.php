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
        return response()->json($badges, 200);
    }

    public function show(Badge $badge)
    {
        return response()->json($badge, 200);
    }

    public function getUserBadges()
    {
        $badges = request()->user()->badges;
        return response()->json($badges);
    }

    public function update(Badge $badge, BadgeRequest $request)
    {
        $this->authorize('admin');
        $validated = $request->validated();
        $badge->updateOrFail($validated);
        return response()->json($badge, 200);
    }

    public function store(BadgeRequest $request)
    {
        $this->authorize('admin');
        $validated = $request->validated();
        $badge = Badge::create($validated);
        return response()->json($badge, 201);
    }

    public function destroy(Badge $badge)
    {
        $this->authorize('admin');
        $badge->deleteOrFail();
        return response()->json($badge, 202);
    }
}
