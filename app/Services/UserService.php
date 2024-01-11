<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Validator;

class UserService
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $username = $request->get('username');
        $email = $request->get('email');
        $sort = $request->get('sort');
        $direction = $request->get('direction');

        // Query builder for users
        $query = $this->userRepository->getUserAndUsergroupByQuery();

        // Check conditions and build the query accordingly
        if ($username || $email) {
           $query = $this->userRepository->getUsersBySearchQuery($query, $username, $email);
        }
        if ($sort && $direction) {
            $query = $this->userRepository->getUsersByOrderBy($query, $sort, $direction);
        }
        // Execute the query
        $users = $this->userRepository->index($query);

        // Return the response
        return $users;
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username" => "required",
            "firstName" => "required",
            "lastName" => "required",
            "email" => "required|email",
            "password" => "required",
        ]);

        if ($validator->fails()) {
            $response = [
                "success" => false,
                "message" => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $input = $request->all();
        $input["password"] = bcrypt($input["password"]);
        $this->userRepository->create($input);
    }

    public function getSingleUser($id)
    {
        return $this->userRepository->getSingleUser($id);
    }
    public function getUsersWithSpecifiedGroupId($groupId = null)
    {

        return $this->userRepository->getUsersWithSpecifiedGroupId($groupId);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "username" => "required|min:4|string|max:255",
            "firstName" => "required",
            "lastName" => "required",
            "email" => "required|email",
            "password" => "required",
        ]);

        if ($validator->fails()) {
            $response = [
                "success" => false,
                "message" => $validator->errors()
            ];
            return response()->json($response, 400);
        }
        $input = $request->all();
        $data = array(
            "username" => $request->username,
            "firstName" => $request->firstName,
            "lastName" => $request->lastName,
            "email" => $request->email,
            "groupId" => $request->groupId,
            "password" => bcrypt($input["password"])
        );
        return $this->userRepository->update($data, $id);
    }

    public function destroy($id)
    {
        return $this->userRepository->destroy($id);
    }
}
