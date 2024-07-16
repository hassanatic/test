<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Http\Requests\UsersWithinRadius;
use App\Models\UserLocation;
use Illuminate\Http\Request;

class GeoQuery extends Controller
{
    //
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        
        UserLocation::updateOrCreate(
            ['user_id' => $request->user_id],
            $validated);

        return response()->json(
            ['message' => 'Data stored successfully',
            'code' => 200
        ]);
    }

    public function usersWithinRadius(UsersWithinRadius $request)
    {

        $validated = $request->validated();
        $lat = $validated['lat'];
        $lng = $validated['lng'];
        $radius = $validated['radius'];
        
        $haversine = "(6371000 * acos(cos(radians(?)) * cos(radians(lat)) * cos(radians(lng) - radians(?)) + sin(radians(?)) * sin(radians(lat))))";

        $ids = UserLocation::select('user_id')
            ->selectRaw("{$haversine} AS distance", [$lat, $lng, $lat])
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->pluck('user_id');
        return response()->json(
            ['code' => 200,
            'data' => $ids
        ]);
    }
}
