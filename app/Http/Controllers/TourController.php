<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourController extends Controller
{
    /**
     * Mark the system tour as completed for the current user.
     */
    public function complete(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $user->update(['system_tour_completed' => true]);

        return response()->json(['success' => true, 'completed' => true]);
    }

    /**
     * Reset the system tour status so the user can run it again.
     */
    public function reset(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $user->update(['system_tour_completed' => false]);

        return response()->json(['success' => true, 'completed' => false]);
    }
}
