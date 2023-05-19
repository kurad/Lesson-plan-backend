<?php

namespace App\Services;

use Exception;
use App\Models\Lesson;
use App\Models\Activity;
use App\Models\LessonPart;
use Illuminate\Support\Facades\DB;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ItemNotFoundException;
use App\DTO\LessonParts\CreateLessonPartDto;
use App\DTO\LessonParts\UpdateLessonPartDto;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\InvalidDataGivenException;

class LessonPartsService extends AbstractService
{
    /**
     * @throws Exception
     */
    public function createLessonPart(CreateLessonPartDto $data): LessonPart
    {

        $type = $data->type;
        $duration = $data->duration;
        $lessonId = $data->lessonId;


        $lesson = Lesson::find($lessonId);
        if (is_null($lesson)) {
            throw new ItemNotFoundException("There is no such lesson found");
        }


        try {
            $lessonPart = LessonPart::create([
                "type" => $type,
                "duration" => $duration,
                "lesson_id" => $lessonId,

            ]);
            // $partId=DB::table('activities')->latest();
            
            // Activity::create([
            //     "lesson_part_id" => $partId
            // ]);
            return $lessonPart;
        } catch (Exception $th) {
            Log::error("Failed to create a lesson Part ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function getLessonPart(int $id): ?LessonPart
    {
        $lessonPart = LessonPart::find($id);
        if (is_null($lessonPart)) {
            throw new ItemNotFoundException("Sorry, lesson part can not be found");
        }
        return $lessonPart;
    }

    public function allLessonParts(): Collection
    {
        $lessonParts = LessonPart::all();

        return $lessonParts;
    }


    public function lessonPartsPerLesson(int $id){

        $lessonPart = LessonPart::join('lessons','lesson_parts.lesson_id','=','lessons.id')
                                ->join('units','lessons.unit_id','=','units.id')
                                ->join('subjects','units.subject_id','=','subjects.id')
                                ->join('class_setups','subjects.class_id','=','class_setups.id')
                                ->where('lesson_parts.lesson_id','=', $id)
                                ->select('lessons.id as lessonId','lesson_parts.id','lesson_parts.type','subjects.name as subjectName','lessons.title as lessonName', 'class_setups.name','lesson_parts.duration')
                                ->select('lesson_parts.id','lesson_parts.type','subjects.name as subjectName','lessons.title as lessonName', 'class_setups.name','lesson_parts.duration as duration')
                                ->get();

        return $lessonPart;
    }
    public function lessonPartsPerOneLesson(int $id){
        $lessonPart = LessonPart::join('lessons','lesson_parts.lesson_id','=','lessons.id')
                                ->join('units','lessons.unit_id','=','units.id')
                                ->join('subjects','units.subject_id','=','subjects.id')
                                ->join('class_setups','subjects.class_id','=','class_setups.id')
                                ->where('lesson_parts.lesson_id','=', $id)
                                ->select('lessons.id as lessonId','lesson_parts.id','lesson_parts.type','subjects.name as subjectName','lessons.title as lessonName', 'class_setups.name','lesson_parts.duration')
                                ->first();

        return $lessonPart;

    }
    public function getLessonParts(int $id){

        $lessonPart = LessonPart::join('lessons','lesson_parts.lesson_id','=','lessons.id')
                                ->join('units','lessons.unit_id','=','units.id')
                                ->join('subjects','units.subject_id','=','subjects.id')
                                ->join('class_setups','subjects.class_id','=','class_setups.id')
                                ->where('lesson_parts.id','=', $id)
                                ->select('lesson_parts.id','lesson_parts.type','subjects.name as subjectName','lessons.title','class_setups.name','lesson_parts.duration as lessonTime', 'lessons.date')
                                ->first();

        return $lessonPart;
    }
    public function checkLessonParts(int $id)
    {
        $lessonPart = LessonPart::join('lessons','lesson_parts.lesson_id','=','lessons.id')
                                ->where('lesson_parts.lesson_id','=', $id)
                                ->select('lesson_parts.id','lesson_parts.type','lessons.title','lesson_parts.duration as lessonTime', 'lessons.date')
                                ->get();

        return $lessonPart;
    }


    public function lessonPartsActivities(int $id){
        $userId = Auth::user()->id;
        $lessonPart = LessonPart::join('lessons','lesson_parts.lesson_id','=','lessons.id')
                                ->join('units','lessons.unit_id','=','units.id')
                                ->join('subjects','units.subject_id','=','subjects.id')
                                ->join('class_setups','subjects.class_id','=','class_setups.id')
                                ->where('class_setups.user_id','=', $userId)
                                ->where('lesson_parts.id','=', $id)
                                ->select('lesson_parts.*','subjects.*','lessons.*','class_setups.*','lesson_parts.duration as lessonTime')
                                ->first();

        return $lessonPart;
    }

    public function updateLessonPart(UpdateLessonPartDto $data, int $id): LessonPart
    {
        $lessonPart = LessonPart::find($id);
        if (is_null($lessonPart)) {
            throw new InvalidDataGivenException("The lesson part does not exist");
        }

        $duration = $data->duration;

        try {
            $lessonPart->update([
                "duration" => $duration,
            ]);

            return $lessonPart;
        } catch (Exception $th) {

            Log::error("Failed to update lesson part ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function destroyLessonPart(int $id): bool
    {
        $lessonPart = LessonPart::find($id);
        if (is_null($lessonPart)) {
            throw new InvalidDataGivenException("The lesson Part does not exist");
        }

        return $lessonPart->delete();
    }
}