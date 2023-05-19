<?php

namespace App\Services;


use App\DTO\Unit\CreateUnitDto;
use App\DTO\Unit\UpdateUnitDto;
use App\Exceptions\InvalidDataGivenException;
use App\Exceptions\ItemNotFoundException;
use App\Exceptions\UknownException;
use App\Models\Subject;
use App\Models\Unit;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class UnitService extends AbstractService
{

    /**
     * @throws Exception
     */
    public function createUnit(CreateUnitDto $data): Unit
    {

        $title = $data->title;
        $unitNo = $data->unitNo;
        $unitCompetence = $data->unitCompetence;
        $subjectId = $data->subjectId;

        $unitExists = Unit::where("title", $title)->exists();
        if ($unitExists) {
            throw new InvalidDataGivenException("Unit  already exists");
        }

        $subject = Subject::find($subjectId);
        if (is_null($subject)) {
            throw new ItemNotFoundException("There is no such Subject");
        }

        try {
            $unit = Unit::create([
                "title" => $title,
                "unit_no" => $unitNo,
                "key_unit_competence" => $unitCompetence,
                "subject_id" => $subjectId,

            ]);

            return $unit;
        } catch (Exception $th) {
            Log::error("Failed to create a unit ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function getUnit(int $id): ?Unit
    {
        $unit = Unit::find($id);
        if (is_null($unit)) {
            throw new ItemNotFoundException("Sorry, unit can not be found");
        }
        return $unit;
    }

    public function allUnits(): Collection
    {
        //$units = Unit::with("subject")->get();
        $units = Unit::join('subjects','subjects.id','=','units.subject_id')
                    ->join('class_setups','subjects.class_id','=','class_setups.id')
                    ->join('users','users.id','=','class_setups.user_id')
                    ->select('users.*','class_setups.name as className','subjects.name as subjectName','units.*')
                    ->get();
        return $units;
    }

    public function Units(): Collection
    {
        $units = Unit::join('subjects','subjects.id','=','units.subject_id')
                    ->join('class_setups','subjects.class_id','=','class_setups.id')
                    ->join('users','users.id','=','class_setups.user_id')
                    ->select('users.id','users.f_name','users.l_name','class_setups.name as className','subjects.name as subjectName','units.*')
                    ->groupBy('users.f_name')
                    //->having()
                    ->get();

        return $units;
    }

    public function unitsPerSubject(int $subjectId): Collection
    {
        $units = Unit::where("subject_id", "=", $subjectId)->get();
        return $units;
    }

    public function unitsPerUser(): Collection
    {
        $userId = Auth::user()->id;

        $units = Unit::join('subjects',"subjects.id","units.subject_id")
                        ->join('class_setups','class_setups.id','=','subjects.class_id')
                        ->where("class_setups.user_id","=", $userId)
                        ->get(['subjects.*','units.*']);
        return $units;
    }


    public function updateUnit(UpdateUnitDto $data, int $id): Unit
    {
        $unit = Unit::find($id);
        if (is_null($unit)) {
            throw new InvalidDataGivenException("The unit does not exist");
        }

        $title = $data->title;
        $unitNo = $data->unitNo;
        $unitCompetence = $data->unitCompetence;
        $subjectId = $data->subjectId;
        try {
            $unit->update([
                "title" => $title,
                "unit_no" => $unitNo,
                "key_unit_competence" => $unitCompetence,
                "subject_id" => $subjectId,
            ]);

            return $unit;
        } catch (Exception $th) {

            Log::error("Failed to update unit ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function destroyUnit(int $id): bool
    {
        $unit = Unit::find($id);
        if (is_null($unit)) {
            throw new InvalidDataGivenException("The unit does not exist");
        }

        return $unit->delete();
    }
}