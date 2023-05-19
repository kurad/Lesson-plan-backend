<?php

namespace App\Services;


use App\DTO\LessonTeacherActivities\CreateLessonTeacherActivitiesDto;
use App\DTO\LessonTeacherActivities\UpdateLessonTeacherActivitiesDto;
use App\Exceptions\InvalidDataGivenException;
use App\Exceptions\ItemNotFoundException;
use App\Exceptions\UknownException;
use App\Models\LessonPart;
use App\Models\LessonPartTeacherActivity;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class LessonTeacherActivitiesService extends AbstractService
{



    /**
     * @throws Exception
     */
    public function createTeacherActivity(CreateLessonTeacherActivitiesDto $data): LessonPartTeacherActivity
    {

        $content = $data->content;
        $lessonPartId = $data->lessonPartId;


        $lesson = LessonPart::find($lessonPartId);
        if (is_null($lesson)) {
            throw new ItemNotFoundException("There is no such lesson part found");
        }

        try {
            $lesson = LessonPartTeacherActivity::create([
                "content" => $content,
                "lesson_part_id" => $lessonPartId,

            ]);

            return $lesson;
        } catch (Exception $th) {
            Log::error("Failed to create a lesson Teacher Activity part ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function getTeacherActivity(int $id): ?LessonPartTeacherActivity
    {
        $lesson = LessonPartTeacherActivity::find($id);
        if (is_null($lesson)) {
            throw new ItemNotFoundException("Sorry, lesson part can not be found");
        }
        return $lesson;
    }

    public function getTeacherActivities(int $id)
    {
        $activities = LessonPartTeacherActivity::join('lesson_parts','lesson_part_teacher_activities.lesson_part_id','=','lesson_parts.id')
                                            ->join('lessons','lesson_parts.lesson_id','=','lessons.id')
                                            ->where('lesson_parts.id','=',$id)
                                            ->select('lessons.title','lessons.date','lesson_parts.type','lesson_parts.duration as partDuration',
                                                'lesson_part_teacher_activities.content')
                                            ->first();
        return $activities;
    }

    public function allTeacherActivities(): Collection
    {

        $activities = LessonPartTeacherActivity::all();

        return $activities;
    }

    public function TeacherActivityPerLesson(int $lessonId): Collection
    {
        $lesson = LessonPartTeacherActivity::with('lessonPart')->find($lessonId);
        return $lesson;
    }


    public function updateTeacherActivity(UpdateLessonTeacherActivitiesDto $data, int $id): LessonPartTeacherActivity
    {
        $lesson = LessonPartTeacherActivity::find($id);
        if (is_null($lesson)) {
            throw new InvalidDataGivenException("The lesson Teacher Activity does not exist");
        }

        $content = $data->content;
        $lessonPartId = $data->lessonPartId;

        try {
            $lesson->update([
                "content" => $content,
                "lesson_part_id" => $lessonPartId,
            ]);

            return $lesson;
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

    public function destroyTeacherActivity(int $id): bool
    {
        $lesson = LessonPartTeacherActivity::find($id);
        if (is_null($lesson)) {
            throw new InvalidDataGivenException("The lesson Part does not exist");
        }

        return $lesson->delete();
    }
}
