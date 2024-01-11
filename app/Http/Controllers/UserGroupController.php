<?php

namespace App\Http\Controllers;
use App\Services\UserGroupService;
use App\Models\UserGroup;
use App\Models\User;
use Validator;

use Illuminate\Http\Request;

class UserGroupController extends Controller
{

    protected $usergroupService;
    public function __construct(UserGroupService $usergroupService)
    {
        $this->usergroupService = $usergroupService;
    }

    public function index(Request $request)
    {
        $usergroups = $this->usergroupService->index($request);
        // Return the response
        return response()->json($usergroups);
    }

    public function getSingleUsergroup($id)
    {
        $usergroup = $this->usergroupService->getSingleUsergroup($id);
        $userIds = $this->usergroupService->getUserIdInGroup($usergroup);
        $usergroup["userIds"] = $userIds;
        return response()->json($usergroup);
    }

    public function getUsergroupsWithSpecifiedId($id = null)
    {
        $users = $this->usergroupService->getUsersWithSpecifiedGroupId($id);
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
        $usergroup = $this->usergroupService->create($request);
        $response = [
            "success" => true,
            "data" => $usergroup,
            "message" => "Usergroups registers successfully"
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserGroup  $usergroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $usergroup = $this->usergroupService->update($request, $id);
        $response = [
            "success" => true,
            "data" => $usergroup,
            "message" => "Update usergroup successfully"
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
        $this->usergroupService->destroy($id);
        return response()->json([
            'message' => 'Usergroup deleted Successfully!!'
        ]);
    }
}
