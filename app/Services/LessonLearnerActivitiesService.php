<?php

namespace App\Services;


use App\DTO\LessonStudentActivities\CreateLessonStudentActivitiesDto;
use App\DTO\LessonStudentActivities\UpdateLessonStudentActivitiesDto;
use App\Exceptions\InvalidDataGivenException;
use App\Exceptions\ItemNotFoundException;
use App\Exceptions\UknownException;
use App\Models\LessonPart;
use App\Models\LessonPartLearnerActivity;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class LessonLearnerActivitiesService extends AbstractService
{



    /**
     * @throws Exception
     */
    public function createLearnerActivity(CreateLessonStudentActivitiesDto $data): LessonPartLearnerActivity
    {

        $content = $data->content;
        $lessonPartId = $data->lessonPartId;


        $lesson = LessonPart::find($lessonPartId);
        if (is_null($lesson)) {
            throw new ItemNotFoundException("There is no such lesson part found");
        }

        try {
            $lesson = LessonPartLearnerActivity::create([
                "content" => $content,
                "lesson_part_id" => $lessonPartId,

            ]);

            return $lesson;
        } catch (Exception $th) {
            Log::error("Failed to create a lesson Learner Activity part ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function getLearnerActivity(int $id): ?LessonPartLearnerActivity
    {
        $lesson = LessonPartLearnerActivity::find($id);
        if (is_null($lesson)) {
            throw new ItemNotFoundException("Sorry, lesson part can not be found");
        }
        return $lesson;
    }
    public function getLearnerActivities(int $id)
    {
        $activities = LessonPartLearnerActivity::join('lesson_parts','lesson_part_learner_activities.lesson_part_id','=','lesson_parts.id')
                                            ->join('lessons','lesson_parts.lesson_id','=','lessons.id')
                                            ->where('lesson_parts.id','=',$id)
                                            ->select('lessons.title','lessons.date','lesson_parts.type','lesson_parts.duration as partDuration',
                                                'lesson_part_learner_activities.content')
                                            ->first();
        return $activities;
    }

    public function allLearnerActivities(): Collection
    {

        $activities = LessonPartLearnerActivity::all();

        return $activities;
    }

    public function LearnerActivityPerLesson(int $lessonId): Collection
    {
        $lesson = LessonPartLearnerActivity::with('lessonPart')->find($lessonId);
        return $lesson;
    }


    public function updateLearnerActivity(UpdateLessonStudentActivitiesDto $data, int $id): LessonPartLearnerActivity
    {
        $lesson = LessonPartLearnerActivity::find($id);
        if (is_null($lesson)) {
            throw new InvalidDataGivenException("The lesson Learner Activity does not exist");
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

    public function destroyLearnerActivity(int $id): bool
    {
        $lesson = LessonPartLearnerActivity::find($id);
        if (is_null($lesson)) {
            throw new InvalidDataGivenException("The lesson Part does not exist");
        }

        return $lesson->delete();
    }
}
