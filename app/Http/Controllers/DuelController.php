<?php

namespace App\Http\Controllers;

use App\Models\DuelRequest;
use App\Models\User;
use App\Notifications\NewDuelRequestNotification;
use Illuminate\Http\Request;

class DuelController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'to_user_id' => 'required|exists:users,id|different:auth_user_id',
        ]);

        $from = auth()->id();
        $to = $request->to_user_id;

        $exists = DuelRequest::where('from_user_id', $from)
            ->where('to_user_id', $to)
            ->where('status', 'pending')
            ->exists();

        if ($exists) return response()->json(['error' => 'You already sent a request.'], 422);

        $duel = DuelRequest::create([
            'from_user_id' => $from,
            'to_user_id' => $to,
            'expired_at' => now()->addMinutes(3),
        ]);

        $toUser = User::find($to);
        $toUser->notify(new NewDuelRequestNotification($duel));

        return response()->json(['message' => 'Duel request sent.']);
    }

    public function accept($id)
    {
        $duel = DuelRequest::findOrFail($id);

        if ($duel->to_user_id !== auth()->id())
            return response()->json(['error' => 'Unauthorized'], 403);

        if ($duel->status !== 'pending')
            return response()->json(['error' => 'Already handled'], 422);

        $duel->update(['status' => 'accepted']);

        return response()->json(['message' => 'Duel accepted.']);
    }

    public function reject($id)
    {
        $duel = DuelRequest::findOrFail($id);

        if ($duel->to_user_id !== auth()->id())
            return response()->json(['error' => 'Unauthorized'], 403);

        if ($duel->status !== 'pending')
            return response()->json(['error' => 'Already handled'], 422);

        $duel->update(['status' => 'rejected']);

        return response()->json(['message' => 'Duel rejected.']);
    }

    public function list()
    {
        $userId = auth()->id();
        $duels = DuelRequest::where('from_user_id', $userId)
            ->orWhere('to_user_id', $userId)
            ->latest()
            ->get();

        return response()->json($duels);
    }

}
