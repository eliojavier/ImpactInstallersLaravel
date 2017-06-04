<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Http\Requests\AssignmentRequest;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::findOrFail($request->user()->id);

        if ($user->role == 'Supervisor'){
            $assignments = DB::select("select a.id, concat(u.name, \" \", u.last_name) as installerName, a.date, a.time, a.clientName, l.name as location, a.address, a.status
            from assignments a, users u, locations l where u.id = a.user_id and l.id = a.location_id");

            return response()->json([
                'assignments' => $assignments,
            ]);
        }

        if ($user->role == 'Employee'){
            $assignments = DB::select("select a.id, concat(u.name, \" \", u.last_name) as installerName, a.date, a.time, a.clientName, l.name as location, a.address, a.status
            from assignments a, users u, locations l where u.id = a.user_id and l.id = a.location_id and u.id=$user->id");

            return response()->json([
                'assignments' => $assignments,
            ]);
        }

        return response()->json([
            'assignments' => null,
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
     * @param AssignmentRequest|Request $request
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
        $assignment = DB::select("select a.date, a.time, a.clientName , a.clientEmail, l.name as location, a.address, concat(u.name, \" \", u.last_name) as name
                                from assignments a, locations l, users u
                                where u.id = a.user_id and l.id = a.location_id and a.id = $id");
        return response()->json([
            'assignment' => $assignment,
        ]);
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
     * @param AssignmentRequest|Request $request
     * @param Assignment $assignment
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(AssignmentRequest $request, Assignment $assignment)
    {
        try {
            $assignment->user_id = $request->name;
            $assignment->date = $request->date;
            $assignment->time = $request->time;
            $assignment->clientName = $request->clientName;
            $assignment->clientEmail = $request->clientEmail;
            $assignment->location_id = $request->location;
            $assignment->address = $request->address;

            $assignment->update();

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
     * Remove the specified resource from storage.
     *
     * @param  Assignment $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
    {

    }
}
