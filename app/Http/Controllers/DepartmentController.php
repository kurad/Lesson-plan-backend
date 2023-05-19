<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\CreateDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DepartmentController extends Controller
{
    public function __construct(public DepartmentService $departmentService)
    {
    }


    public function departments()
    {

        $departments = $this->departmentService->allDepartments()->toArray();

        return Response::json($departments);
    }

    public function getDepartment(int $id)
    {
        try {
            $department = $this->departmentService->findOneDepartment($id);
            return Response::json($department);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function create(CreateDepartmentRequest $request)
    {
        try {

            $department = $this->departmentService->createDepartment($request->dto);
            return Response::json($department);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function updateDepartment(UpdateDepartmentRequest $request, int $id)
    {
        try {
            $department = $this->departmentService->updateDepartment($request->dto, $id);
            return Response::json($department);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function destroyDepartment(int $id)
    {
        try {
            $department = $this->departmentService->destroyDepartment($id);
            return Response::json($department);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
}