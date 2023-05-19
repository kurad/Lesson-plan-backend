<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserManagementController extends Controller
{

    public function __construct(public UserService $userService)
    {
    }


    public function allUsers()
    {

        $result = $this->userService->allUsers()->toArray();

        return Response::json($result);
    }

    public function getUser(int $id)
    {
        try {
            $user = $this->userService->findOneUser($id);
            return Response::json($user);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function getUserDepartment(int $id)
    {
        try {
            $user = $this->userService->findUserDepartment($id);
            return Response::json($user);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function create(CreateUserRequest $request)
    {
        try {

            $user = $this->userService->createUser($request->dto);
            return Response::json($user);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function updateUser(UpdateUserRequest $request, int $id)
    {
        try {

            $user = $this->userService->updateUser($request->dto, $id);
            return Response::json($user);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function destroyUser(int $id)
    {
        try {
            $user = $this->userService->destroyUser($id);
            return Response::json($user);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
}
