<?php

namespace App\Services;

use App\DTO\User\CreateUserDto;
use App\DTO\User\UpdateUserDto;
use App\DTO\UserRole\UpdateUserRoleDto;
use App\Models\Department;
use App\Models\Role;
use App\Models\Role_User;
use App\Models\User;
use App\Models\UserType;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use DB;

class UserService extends AbstractService
{



    /**
     * @throws Exception
     */
    public function createUser(CreateUserDto $data): User
    {

        $f_name = $data->firstName;
        $l_name = $data->lastName;
        $departmentId = $data->departmentId;
        $typeId = $data->userTypeId;
        $email = $data->email;
        $phoneNumber = $data->phoneNumber;
        $password = bcrypt($data->password);


        $emailExists = User::where("email", $email)->exists();
        if ($emailExists) {
            throw new Exception("User email already exists");
        }

        $phoneNumberExists = User::where("phone", $phoneNumber)->exists();
        if ($phoneNumberExists) {
            throw new Exception("User phone number already exists");
        }

        $department = Department::find($departmentId);
        if (is_null($department)) {
            throw new Exception("There is no such department");
        }


        $type = UserType::find($typeId);
        if (is_null($type)) {
            throw new Exception("There is no such user type");
        }


        try {
            $user = User::create([
                "department_id" => $departmentId,
                "user_type_id" => $typeId,
                "f_name" => $f_name,
                "l_name" => $l_name,
                "phone" => $phoneNumber,
                "email" => $email,
                "password" => $password,
            ]);

            return $user;
        } catch (Exception $th) {
            Log::error("Failed to create user ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new Exception("Sorry, there were some issues, contact the system admin");
        }
    }

    public function findOneUser(int $id): ?User
    {
        $user = User::find($id);
        if (is_null($user)) {
            throw new Exception("Sorry, user can not be found");
        }
        return $user;
    }

    public function findUserDepartment(int $id): ?User
    {
        $user = User::with("department", "usertype")->find($id);
        if (is_null($user)) {
            throw new Exception("Sorry, user can not be found");
        }
        return $user;
    }

    public function allUsers(): Collection
    {
        $users = User::all();

        return $users;
    }
    public function getAllUsers()
    {
        $users = User::join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->join('departments', 'departments.id', '=', 'users.department_id')
            ->select('roles.name as Role', 'role_user.*', 'users.*', 'departments.name as DepName')
            ->get();
        return $users;
    }
    public function getUserDetail(int $id): ?User
    {
        $user = User::join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->join('departments', 'departments.id', '=', 'users.department_id')
            ->select('roles.name as Role', 'role_user.*', 'users.*', 'departments.name as DepName')
            ->where('users.id', '=', $id)
            ->first();
        if (is_null($user)) {
            throw new Exception("Sorry, user can not be found");
        }
        return $user;
    }
    public function getRole()
    {
        $roles = Role::all();
        return $roles;
    }

    public function usersPerDepartment(int $departmentId): Collection
    {
        $users = User::where("department_id", "=", $departmentId)->get();
        return $users;
    }

    public function usersPerType(int $type_id): Collection
    {
        $users = User::where("user_type_id", "=", $type_id)->get();

        return $users;
    }
    public function updateUser(UpdateUserDto $data, int $id): User
    {
        $user = User::find($id);
        if (is_null($user)) {
            throw new Exception("The user does not exist");
        }
        $f_name = $data->firstName;
        $l_name = $data->lastName;
        $departmentId = $data->departmentId;
        $typeId = $data->userTypeId;
        $email = $data->email;
        $phoneNumber = $data->phoneNumber;

        try {
            $user->update([
                "department_id" => $departmentId,
                "user_type_id" => $typeId,
                "f_name" => $f_name,
                "l_name" => $l_name,
                "phone" => $phoneNumber,
                "email" => $email,
            ]);

            return $user;
        } catch (Exception $th) {

            Log::error("Failed to update user ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new Exception("Sorry, there were some issues, contact the system admin");
        }
    }
    public function destroyUser(int $id): bool
    {
        $user = User::find($id);
        if (is_null($user)) {
            throw new Exception("The user does not exist");
        }

        return $user->delete();
    }
}