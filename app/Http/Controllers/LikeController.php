<?php 


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LikedSneaker;

class LikeController extends Controller
{
    public function toggleLike(Request $request, $sneakerId)
    {
        $user = $request->user();

        $like = LikedSneaker::where('user_id', $user->id)
            ->where('sneaker_id', $sneakerId)
            ->first();

        if ($like) {
            // Unlike if already liked
            $like->delete();
            $message = 'Sneaker unliked successfully';
        } else {
            // Like if not liked
            LikedSneaker::create([
                'user_id' => $user->id,
                'sneaker_id' => $sneakerId,
            ]);
            $message = 'Sneaker liked successfully';
        }

        return response()->json(['message' => $message]);
    }
}
