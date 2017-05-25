<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::all();
        return response()->json([
            'locations' => $locations
        ])->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationRequest $request)
    {
        try {
            $location = new Location();

            $location->name = $request->name;
            $location->state = $request->state;
            $location->city = $request->city;
            $location->postalCode = $request->postalCode;
            $location->lat = $request->lat;
            $location->lon = $request->long;

            $location->save();

            return response()->json([
                'code' => '201',
            ])->setStatusCode(201);

        }
        catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ])->setStatusCode(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        return response()->json([
            'deleted' => $location->delete()
        ])->setStatusCode(200);
    }
}
