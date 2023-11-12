<?php 



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'sneaker_id' => 'required|exists:sneakers,id',
            'comment' => 'required|string',
        ]);

        $user = $request->user();
        $date = Carbon::now();

        $review = Review::create([
            'sneaker_id' => $request->input('sneaker_id'),
            'user_id' => $user->id,
            'comment' => $request->input('comment'),
            'date' => $date,
            'updated_at' => $date,
            'created_at' => $date,
        ]);

        return response()->json($review, 201);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }

    public function getReviewsBySneaker($sneakerId)
    {
        $reviews = Review::where('sneaker_id', $sneakerId)
            ->with('user:id,username') // Load the user relationship with only the id and username
            ->get();

        return response()->json($reviews);
    }
}