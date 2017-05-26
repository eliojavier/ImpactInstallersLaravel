<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Http\Requests\AssignmentRequest;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $assignments = Assignment::with('user')->with('location')->get();
//        return response()->json([
//            'assignments' => $assignments,
//        ]);
        $assignments = DB::select("select a.id, concat(u.name, \" \", u.last_name) as installerName, a.date, a.time, a.clientName, l.name as location, a.address, a.status
        from assignments a, users u, locations l where u.id = a.user_id and l.id = a.location_id");
        return response()->json([
            'assignments' => $assignments,
        ]);
    }

    /**
     * @param Request $request
     * @param Assignment $assignment
     * @return $this
     */
    public function updateStatus(Request $request, Assignment $assignment)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->messages()
            ])->setStatusCode(400);
        }
        try {
            $assignment->status = $request->status;
            $assignment->update();

            return response()->json($assignment)->setStatusCode(201);
        }
        catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ])->setStatusCode(500);
        }
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
    public function store(AssignmentRequest $request)
    {
        try {
            $assignment = new Assignment();

            $assignment->user_id = $request->name;
            $assignment->date = $request->date;
            $assignment->time = $request->time;
            $assignment->clientName = $request->clientName;
            $assignment->clientEmail = $request->clientEmail;
            $assignment->location_id = $request->location;
            $assignment->address = $request->address;
            $assignment->status = "Active";

            $assignment->save();

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Assignment $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
    {

    }
}
