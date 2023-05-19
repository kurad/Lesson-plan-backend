<?php

namespace App\Services;

use App\DTO\LessonEvaluation\CreateLessonEvaluationDto;
use App\DTO\LessonEvaluation\UpdateLessonEvaluationDto;
use App\DTO\LessonParts\CreateLessonPartDto;
use App\DTO\LessonParts\UpdateLessonPartDto;
use App\Exceptions\InvalidDataGivenException;
use App\Exceptions\ItemNotFoundException;
use App\Exceptions\UknownException;
use App\Models\Lesson;
use App\Models\LessonPart;
use App\Models\LessonPartEvaluation;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LessonEvaluationService extends AbstractService
{



    /**
     * @throws Exception
     */
    public function createLessonEvaluation(CreateLessonEvaluationDto $data): LessonPartEvaluation
    {

        $content = $data->content;
        $lessonPartId = $data->lessonPartId;


        $lesson = LessonPart::find($lessonPartId);
        if (is_null($lesson)) {
            throw new ItemNotFoundException("There is no such lesson part found");
        }

        try {
            $lesson = LessonPartEvaluation::create([
                "content" => $content,
                "lesson_part_id" => $lessonPartId,

            ]);

            return $lesson;
        } catch (Exception $th) {
            Log::error("Failed to create a lesson Evaluation ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function getLessonEvaluation(int $id): ?LessonPartEvaluation
    {
        $evaluation = LessonPartEvaluation::find($id);
        if (is_null($evaluation)) {
            throw new ItemNotFoundException("Sorry, lesson part can not be found");
        }
        return $evaluation;
    }

    public function allEvaluation(): Collection
    {
        $evaluations = LessonPartEvaluation::all();

        return $evaluations;
    }

    public function evaluationPerLesson(int $lessonId): Collection
    {
        $evaluation = LessonPartEvaluation::join('lesson_parts', 'lesson_parts.id', '=', 'lesson_part_evaluations.lesson_part_id')
            ->join('lessons', 'lessons.id', '=', 'lesson_parts.lesson_id')
            ->where("lesson_id", "=", $lessonId)->get();
        return $evaluation;
    }

    public function lessonEvaluationPerUser(int $lessonId)
    {
        $user = Auth::id();
        $lessonEvaluation = LessonPartEvaluation::join('lesson_parts', 'lesson_parts.id', '=', 'lesson_part_evaluations.lesson_part_id')
                                    ->join('lessons','lesson_parts.lesson_id','=','lessons.id')
                                    ->join('units','lessons.unit_id','=','units.id')
                                    ->join('subjects', 'subjects.id', '=', 'units.subject_id')
                                    ->join('class_setups', 'class_setups.id', '=', 'subjects.class_id')
                                    ->where('class_setups.user_id', '=', $user)
                                    ->where('lessons.id','=',$lessonId)
                                    ->select('lessons.id', 'lessons.title', 'lessons.topic_area', 'units.title as unitName', 'lessons.date', 'lessons.instructional_objective','lesson_parts.type','lesson_parts.duration as partDuration','lesson_part_evaluations.content')
                                    ->first();

        return $lessonEvaluation;
    }



    public function updateLessonEvaluation(UpdateLessonEvaluationDto $data, int $id): LessonPartEvaluation
    {
        $evaluation = LessonPartEvaluation::find($id);
        if (is_null($evaluation)) {
            throw new InvalidDataGivenException("The lesson evaluation does not exist");
        }

        $content = $data->content;
        $lessonPartId = $data->lessonTypeId;

        try {
            $evaluation->update([
                "content" => $content,
                "lesson_part_id" => $lessonPartId,
            ]);

            return $evaluation;
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

    public function destroyLessonEvaluation(int $id): bool
    {
        $evaluation = LessonPartEvaluation::find($id);
        if (is_null($evaluation)) {
            throw new InvalidDataGivenException("The lesson Part does not exist");
        }

        return $evaluation->delete();
    }
}
