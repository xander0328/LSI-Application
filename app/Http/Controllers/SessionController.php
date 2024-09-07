<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UserSession;


class SessionController extends Controller
{
    public function check_session(Request $request)
    {
        $sessionId = $request->session()->getId();

        $sessionExists = UserSession::where('session_id', $sessionId)->exists();

        if (!$sessionExists) {
            Auth::logout();
            return response()->json(['session_exists' => false], 401);
        }

        return response()->json(['session_exists' => true]);
    }
}
