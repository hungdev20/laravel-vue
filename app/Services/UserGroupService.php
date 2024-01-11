<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\UserGroupRepository;
use App\Models\User;
use Validator;

class UserGroupService
{
    protected $usergroupRepository;
    public function __construct(UserGroupRepository $usergroupRepository)
    {
        $this->usergroupRepository = $usergroupRepository;
    }
    public function index(Request $request)
    {
        $name = $request->get('name');
        $description = $request->get('description');
        $sort = $request->get('sort');
        $direction = $request->get('direction');
        $query = $this->usergroupRepository->sortUsergroup();
        if (($name || $description)) {
            $query = $this->usergroupRepository->getUsergroupsBySearchQuery($query, $name, $description);
        }
        if ($sort && $direction) {
            $query = $this->usergroupRepository->getUsergroupsByOrderBy($query, $sort, $direction);
        }
        $usergroups = $this->usergroupRepository->index($query);

        // Return the response
        return $usergroups;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|min:4|string|max:255",
            "description" => "required",
        ]);

        if ($validator->fails()) {
            $response = [
                "success" => false,
                "message" => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $input = [
            "name" => $request->name,
            "description" => $request->description,
        ];
        $usergroup = $this->usergroupRepository->create($input);
        if ($request->userIds) {
            $this->usergroupRepository->updateUserInUsergroup($request->userIds,  $usergroup->id);
        }
        return $usergroup;
    }

    public function getSingleUsergroup($id)
    {
        return $this->usergroupRepository->getSingleUsergroup($id);
    }

    public function getUserIdInGroup($query)
    {
        return $this->usergroupRepository->getUserIdInGroup($query);
    }
    public function getUsersWithSpecifiedGroupId($groupId = null)
    {

        return $this->usergroupRepository->getUsersWithSpecifiedGroupId($groupId);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|min:4|string|max:255",
            "description" => "required",
        ]);
        // Check validation
        if ($validator->fails()) {
            $response = [
                "success" => false,
                "message" => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $payload = [
            "name" => $request->name,
            "description" => $request->description
        ];
        $usergroup = $this->usergroupRepository->update($id, $payload);
        if ($request->userIds) {
            $this->usergroupRepository->updateUserInUsergroup($request->userIds,  $id);
            $this->usergroupRepository->updateUserInUsergroup($id,  NULL);
        }
        return $usergroup;
    }

    public function destroy($id)
    {
        $query = $this->usergroupRepository->getSingleUsergroup($id);
        $userId = $this->usergroupRepository->getUserIdInGroup($query);
        $this->usergroupRepository->updateUserInUsergroup($userId,  NULL);
        return $this->usergroupRepository->destroy($id);
    }
}
