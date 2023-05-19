<?php

namespace App\Services;

use App\DTO\Classes\CreateClassDto;
use App\DTO\Classes\UpdateClassDto;
use App\Exceptions\InvalidDataGivenException;
use App\Exceptions\ItemNotFoundException;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassSetup;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ClassService extends AbstractService
{

    /**
     * @throws Exception
     */
    public function createClass(CreateClassDto $data): ClassSetup
    {
        //$userId = Auth::user()->id;

        $name = $data->name;
        $size = $data->size;
        $SEN = $data->SEN;
        $location = $data->location;
        $userId = Auth::user()->id;


        $classExists = ClassSetup::where("name", $name)->exists();
        if ($classExists) {
            throw new InvalidDataGivenException("Class name already exists");
        }

        try {
            $class = ClassSetup::create([
                "name" => $name,
                "size" => $size,
                "learner_with_SEN" => $SEN,
                "location" => $location,
                "user_id" =>$userId,
                
            ]);

            return $class;
        } catch (Exception $th) {
            Log::error("Failed to create class ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function getClass(int $id): ?ClassSetup
    {
        $class = ClassSetup::find($id);
        if (is_null($class)) {
            throw new ItemNotFoundException("Sorry, this class cannot be found");
        }
        return $class;
    }

    public function getUserClasses()
    {
        $userId = Auth::user()->id;
        $classes = ClassSetup::join('subjects','subjects.class_id','=','class_setups.id')
                            ->join('users','users.id','=','class_setups.user_id')
                            ->where('users.id','=',$userId)
                            ->select(['class_setups.*','subjects.*','users.*'])
                            ->first();

        return $classes;
    }

    public function allClasses(): Collection
    {
        $classes = ClassSetup::all();

        return $classes;
    }

    public function updateClass(UpdateClassDto $data, int $id): ClassSetup
    {
        $class = ClassSetup::find($id);
        if (is_null($class)) {
            throw new ItemNotFoundException("The Class does not exist");
        }


        $name = $data->name;
        $size = $data->size;
        $SEN = $data->SEN;
        $location = $data->location;

        try {
            $class->update([
                "name" => $name,
                "size" => $size,
                "learner_with_SEN" => $SEN,
                "location" => $location,
            ]);

            return $class;
        } catch (Exception $th) {

            Log::error("Failed to update class ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }
    public function destroyClass(int $id): bool
    {
        $class = ClassSetup::find($id);
        if (is_null($class)) {
            throw new ItemNotFoundException("The Class does not exist");
        }

        return $class->delete();
    }
}