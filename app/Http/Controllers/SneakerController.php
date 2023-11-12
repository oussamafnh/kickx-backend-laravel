<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sneaker;
use App\Models\Link;

class SneakerController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $sneakers = Sneaker::with('links')
            ->withCount('likes', 'reviews')
            ->paginate($perPage);

        return response()->json($sneakers);
    }

    public function show($id)
    {
        $sneaker = Sneaker::with('links')
            ->withCount('likes', 'reviews')
            ->findOrFail($id);

        return response()->json($sneaker);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'sneaker_name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'colorway' => 'nullable|string',
            'release_year' => 'nullable|integer',
            'brand' => 'nullable|string',
            'gender' => 'nullable|string',
            'image_link' => 'nullable|string',
        ]);

        $sneaker = Sneaker::create($request->all());

        return response()->json($sneaker, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sneaker_name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'colorway' => 'nullable|string',
            'release_year' => 'nullable|integer',
            'brand' => 'nullable|string',
            'gender' => 'nullable|string',
            'image_link' => 'nullable|string',
        ]);

        $sneaker = Sneaker::findOrFail($id);
        $sneaker->update($request->all());

        return response()->json($sneaker);
    }

    public function destroy($id)
    {
        $sneaker = Sneaker::findOrFail($id);
        $sneaker->delete();

        return response()->json(['message' => 'Sneaker deleted successfully']);
    }

    public function getLinks($id)
    {
        $sneaker = Sneaker::findOrFail($id);
        $links = $sneaker->links;

        return response()->json($links);
    }


    public function filter(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $query = Sneaker::query();

        if ($request->has('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        if ($request->has('brand')) {
            $query->where('brand', $request->input('brand'));
        }

        if ($request->has('release_year')) {
            $query->where('release_year', $request->input('release_year'));
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        $sneakers = $query->with('links')->paginate($perPage);

        return response()->json($sneakers);
    }
    
}
