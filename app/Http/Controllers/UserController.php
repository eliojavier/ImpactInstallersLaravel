<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Fractal;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $users = fractal($users, new UserTransformer())->toArray();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @internal param UserRequest|Request $request
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
//        $validator = Validator::make($request->all(), [
//            'name' => 'required',
//            'last_name' => 'required',
//            'id_document' => 'required',
//            'email' => 'required',
//            'address' => 'required',
//            'phone' => 'required',
//            'role' => 'required',
//            'password' => 'required|confirmed',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json([
//                'error' => $validator->messages()
//            ])->setStatusCode(400);
//        }

        try {
            $user = new User();

            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->id_document = $request->id_document;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->role = $request->role;

            $user->save();

            $user = fractal($user, new UserTransformer());
            return response()->json($user)->setStatusCode(201);

        }
        catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return response()->json([
                    'error' => 'Email already registered',
                ])->setStatusCode(400);
            }
            return response()->json([
                'error' => $e->getMessage(),
            ])->setStatusCode(500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param $id
     * @internal param User $user
     * @internal param int $id
     */
    public function show(User $user)
    {
        $user = fractal($user, new UserTransformer());
        return response()->json($user)->setStatusCode(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->id_document = $request->id_document;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->role = $request->role;

        $user->save();

        $user = fractal($user, new UserTransformer());
        return response()->json($user)->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param $id
     * @internal param User $user
     * @internal param int $id
     */
    public function destroy(User $user)
    {
        return response()->json([
            'deleted' => $user->delete()
        ])->setStatusCode(200);
    }
}
