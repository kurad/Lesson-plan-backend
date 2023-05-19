<?php

namespace App\Services;

use App\DTO\UserType\CreateUserTypeDto;
use App\DTO\UserType\UpdateUserTypeDto;
use App\Models\UserType;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class UserTypeService extends AbstractService
{

    /**
     * @throws Exception
     */
    public function createUserType(CreateUserTypeDto $data): UserType
    {

        $type = $data->type;


        $userTypeExists = UserType::where("type", $type)->exists();
        if ($userTypeExists) {
            throw new Exception("This user type already exists");
        }

        try {
            $userType = UserType::create([

                "type" => $type,

            ]);

            return $userType;
        } catch (Exception $th) {
            Log::error("Failed to create User Type ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new Exception("Sorry, there were some issues, contact the system admin");
        }
    }

    public function show(int $id): ?UserType
    {
        $userType = UserType::find($id);
        if (is_null($userType)) {
            throw new Exception("Sorry, user type cannot be found");
        }
        return $userType;
    }

    public function userTypes(): Collection
    {
        $userTypes = UserType::all();

        return $userTypes;
    }


    public function updateUserType(UpdateUserTypeDto $data, int $id): UserType
    {
        $userType = UserType::find($id);
        if (is_null($userType)) {
            throw new Exception("The user type does not exist");
        }

        $type = $data->type;

        try {
            $userType->update([
                "type" => $type,
            ]);

            return $userType;
        } catch (Exception $th) {

            Log::error("Failed to update user type ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new Exception("Sorry, there were some issues, contact the system admin");
        }
    }
    public function destroyUserType(int $id): bool
    {
        $userType = UserType::find($id);
        if (is_null($userType)) {
            throw new Exception("The user Type does not exist");
        }

        return $userType->delete();
    }
}