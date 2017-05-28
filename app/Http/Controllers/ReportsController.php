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
            'markers' => $reports
        ]);
    }

    public function rankingInstallers()
    {
        $reports = DB::select("select concat(u.name, ' ', u.last_name) as installer, count(a.id) as quantity
                                from users u, assignments a
                                where u.id = a.user_id and a.status = 'done'
                                group by installer
                                order by quantity desc;");
        return response()->json([
            'installers' => $reports
        ]);
    }

    public function rankingCommissions($month, $year)
    {
        $reports = DB::select("select concat(u.name, ' ', u.last_name) as installer, sum(b.total)*0.1 as commission
                                from users u, assignments a, bills b
                                where u.id = a.user_id and a.id = b.assignment_id and 
                                month(a.date) = '$month' and year(a.date) = '$year'
                                group by installer 
                                order by commission desc;");
        return response()->json([
            'commissions' => $reports
        ]);
    }
}
