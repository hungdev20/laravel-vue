<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->userService->index($request);
        // Return the response
        return response()->json($users);
    }
  
    public function getSingleUser($id)
    {
        $user = $this->userService->getSingleUser($id);
        return response()->json($user);
    }
    public function getUsersWithSpecifiedGroupId($groupId = null)
    {
        if ($groupId) {
            $users = User::whereNull('groupId')->orWhere('groupId', $groupId)->get();
        } else {
            $users = User::whereNull('groupId')->get();
        }
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $this->userService->create($request);
        $response = [
            "success" => true,
            "data" => $user,
            "message" => "User registers successfully"
        ];
        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->userService->update($request, $id);
        $response = [
            "success" => true,
            "data" => $user,
            "message" => "Update user successfully"
        ];
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userService->destroy($id);
        return response()->json([
            'message' => 'User deleted Successfully!!'
        ]);
    }
}
