<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function rankingLocations()
    {
        $reports = DB::select("select concat('[', l.lat,', ' , l.lon, ']') as latLng, l.name, count(a.id) as quantity
                                from locations l, assignments a
                                where l.id = a.location_id
                                and a.status = 'done'
                                group by l.name, latLng
                                order by quantity desc;");
        return response()->json([
            'markers' => $reports,
        ]);
    }
}
