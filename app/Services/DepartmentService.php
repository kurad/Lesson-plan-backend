<?php

namespace App\Services;

use App\DTO\Department\CreateDepartmentDto;
use App\DTO\Department\UpdateDepartmentDto;
use App\Exceptions\InvalidDataGivenException;
use App\Exceptions\ItemNotFoundException;
use App\Exceptions\UknownException;
use App\Models\Department;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class DepartmentService extends AbstractService
{

    /**
     * @throws Exception
     */
    public function createDepartment(CreateDepartmentDto $data): Department
    {

        $name = $data->name;


        $departmentExists = Department::where("name", $name)->exists();
        if ($departmentExists) {
            throw new InvalidDataGivenException("Department already exists");
        }

        try {
            $department = Department::create([

                "name" => $name,

            ]);

            return $department;
        } catch (Exception $th) {
            Log::error("Failed to create Department ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function findOneDepartment(int $id): ?Department
    {
        $department = Department::find($id);
        if (is_null($department)) {
            throw new ItemNotFoundException("Sorry, department can not be found");
        }
        return $department;
    }

    public function allDepartments(): Collection
    {
        $departments = Department::all();

        return $departments;
    }



    public function updateDepartment(UpdateDepartmentDto $data, int $id): Department
    {
        $department = Department::find($id);
        if (is_null($department)) {
            throw new ItemNotFoundException("The department does not exist");
        }

        $name = $data->name;

        try {
            $department->update([
                "name" => $name,
            ]);

            return $department;
        } catch (Exception $th) {

            Log::error("Failed to update department ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }
    public function destroyDepartment(int $id): bool
    {
        $department = Department::find($id);
        if (is_null($department)) {
            throw new ItemNotFoundException("The departement does not exist");
        }

        return $department->delete();
    }
}