<?php

namespace App\Services;

use App\DTO\LessonCompetence\CreateLessonCompetenceDto;
use App\DTO\LessonCompetence\UpdateLessonCompetenceDto;
use App\Exceptions\InvalidDataGivenException;
use App\Exceptions\ItemNotFoundException;
use App\Exceptions\UknownException;
use App\Models\LessonPart;
use App\Models\LessonPartCompetence;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class LessonCompetenceService extends AbstractService
{



    /**
     * @throws Exception
     */
    public function createLessonCompetence(CreateLessonCompetenceDto $data): LessonPartCompetence
    {

        $content = $data->content;
        $lessonPartId = $data->lessonPartId;


        $lesson = LessonPart::find($lessonPartId);
        if (is_null($lesson)) {
            throw new ItemNotFoundException("There is no such lesson part found");
        }

        try {
            $lesson = LessonPartCompetence::create([
                "content" => $content,
                "lesson_part_id" => $lessonPartId,

            ]);

            return $lesson;
        } catch (Exception $th) {
            Log::error("Failed to create a lesson Competence part ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function getLessonCompetence(int $id): ?LessonPartCompetence
    {
        $lesson = LessonPartCompetence::find($id);
        if (is_null($lesson)) {
            throw new ItemNotFoundException("Sorry, lesson part can not be found");
        }
        return $lesson;
    }

    public function allCompetence(): Collection
    {
        $lesson = LessonPartCompetence::all();

        return $lesson;
    }

    public function competencePerLesson(int $lessonId): Collection
    {
        $lesson = LessonPartCompetence::with('lessonPart')->find($lessonId);
        return $lesson;
    }


    public function updateLessonCompetence(UpdateLessonCompetenceDto $data, int $id): LessonPartCompetence
    {
        $lesson = LessonPartCompetence::find($id);
        if (is_null($lesson)) {
            throw new InvalidDataGivenException("The lesson Competence does not exist");
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

    public function destroyLessonCompetence(int $id): bool
    {
        $lesson = LessonPartCompetence::find($id);
        if (is_null($lesson)) {
            throw new InvalidDataGivenException("The lesson Part does not exist");
        }

        return $lesson->delete();
    }
}
