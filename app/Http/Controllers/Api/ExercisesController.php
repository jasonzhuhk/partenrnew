<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExercisesResource;
use App\Exercises;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Validator;

class ExercisesController extends Controller
{

    /** 
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function test()
    {
        return time();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        /*this will be always on the latest*/
        $order_by = $request->order_by ? $request->order_by : 'created_at';
        $result = Exercises::orderBy($order_by, 'desc')->get();

        if (isset($request->search)) {
            $result = full_text_search($result, $request->search, ["id","title"]);
        }

        return ExercisesResource::collection(paginate($result, $request->itemsPerPage, $request->page));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return User
     */
    public function update(Request $request, User $user)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required'
        ]);


        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }


        $user->fill($request->all())->save();

        $return = ["status" => "Success"];
        return response()->json($return, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return User
     */
    public function create(Request $request, User $user)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,',
            'role' => 'required'
        ]);

        $request['password'] = 'abcdefghi';
        if ($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }


        $user->fill($request->all())->save();

        $return = ["status" => "Success"];
        return response()->json($return, 201);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            $return = ["status" => "Success"];
            return response()->json($return, 200);
        } else {
            $return = [
                "status" => "error",
                "error" => [
                    "code" => 500,
                    "errors" => 'Not Deleted'
                ]
            ];
            return response()->json($return, 500);
        }
    }
}
