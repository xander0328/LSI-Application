<?php

namespace App\Http\Controllers;

use App\Models\DeviceToken;
use App\Models\Enrollee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceTokenController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_token' => 'required|string',
        ]);

        $enrollee = Enrollee::where('user_id', auth()->id())->first();

        if (!$enrollee) {
            return response()->json(['message' => 'No matching enrollee found for the provided user ID.'], 404);
        }

        $deviceToken = DeviceToken::updateOrCreate(
            ['user_id' => auth()->id(), 'device_token' => $validated['device_token']],
            ['last_used_at' => Carbon::now()]  // Update 'last_used_at' when token is used
        );

        return response()->json([
            'message' => $deviceToken->wasRecentlyCreated ? 'Token successfully stored.' : 'Token updated successfully.'
        ], 200);
    }
}
