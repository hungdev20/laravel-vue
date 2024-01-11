<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index($query)
    {
        $user = $query->get();
        return $user;
    }


    public function create($attributes)
    {
        return $this->user->create($attributes);
    }

    public function getSingleUser($id)
    {
        $user = $this->user->where('id', $id)->first();
        $user->makeHidden(['password']);
        return $user;
    }
    public function getUsersWithSpecifiedGroupId($groupId = null)
    {
        if ($groupId) {
            $users = $this->user->whereNull('groupId')->orWhere('groupId', $groupId)->get();
        } else {
            $users = $this->user->whereNull('groupId')->get();
        }
        return $users;
    }
    public function update($attributes, $id)
    {
        return $this->user->where("id", $id)->update($attributes);
    }

    public function destroy($id)
    {
        $user = $this->user->find($id);
        return $user->delete();
    }
    public function getUserAndUsergroupByQuery()
    {
        $query = $this->user->query()->with(['usergroup' => function ($query) {
            $query->select('id', 'name');
        }]);
        return $query;
    }
    public function getUsersBySearchQuery($query, $username, $email)
    {
        if($username){
            $query->where('username', 'like', '%' . $username . '%')->get();
        };
        if($email){
            $query->where('email', 'like', '%' . $email . '%')->get();
        }
        return $query;
    }

    public function getUsersByOrderBy($query, $sort, $direction)
    {
        $query->orderBy($sort, $direction)->get();
        return $query;
    }
}
