<?php

namespace App\Services;

use Exception;
use App\Models\Lesson;
use App\Models\Activity;
use App\Models\LessonPart;
use App\DTO\Lesson\UpdateLessonDto;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ItemNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use App\DTO\LessonActivity\CreateLessonActivitiesDto;
use App\DTO\LessonActivity\UpdateTeacherActivitiesDto;


class ActivitiesService extends AbstractService
{



    /**
     * @throws Exception
     */
    public function createLessonActivity(CreateLessonActivitiesDto $data): Activity
    {

        $lessonPartId = $data->lessonPartId;
        $teacherActivities = $data->teacherActivities;
        $learnerActivities = $data->learnerActivities;
        $competences = $data->competences;


        $lessonPart = LessonPart::find($lessonPartId);
        if (is_null($lessonPartId)) {
            throw new ItemNotFoundException("The Lesson Part does not exist");
        }
        try {
            $activity = Activity::create([
                "lesson_part_id" => $lessonPart->id,
                "teacher_activities" => $teacherActivities,
                "learner_activities" => $learnerActivities,
                "competences" => $competences,

            ]);

            return $activity;
        } catch (Exception $th) {

            Log::error("Failed to create Lesson Activities ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);

            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }

    public function getLessonActivity(int $id): ?Activity
    {
        $lessonActivity = Activity::find($id);
        if (is_null($lessonActivity)) {
            throw new ItemNotFoundException("Sorry, Lesson can not be found");
        }
        return $lessonActivity;
    }


    public function latestLessonDetails()
    {
        $user = Auth::user()->id;
        $lesson = Lesson::join('units', 'units.id', '=', 'lessons.unit_id')
            ->join('subjects', 'subjects.id', '=', 'units.subject_id')
            ->join('class_setups', 'class_setups.id', '=', 'subjects.class_id')
            ->where('class_setups.user_id', '=', $user)
            ->select('lessons.id', 'lessons.title', 'lessons.topic_area', 'lessons.duration', 'lessons.date', 'lessons.unit_id', 'class_setups.name', 'lessons.instructional_objective as objectives', 'lessons.date')
            ->latest('lessons.id')
            ->first();

        //dd($user);
        return $lesson;
    }

    public function lessonPerUserPerClass(int $lessonId)
    {
        $user = Auth::user()->id;
        $lesson = Lesson::join('units', 'units.id', '=', 'lessons.unit_id')
            ->join('subjects', 'subjects.id', '=', 'units.subject_id')
            ->join('class_setups', 'class_setups.id', '=', 'subjects.class_id')
            ->where('class_setups.user_id', '=', $user)
            ->where('lessons.id', '=', $lessonId)
            ->select('lessons.id', 'lessons.title', 'lessons.topic_area', 'lessons.duration', 'lessons.date', 'lessons.unit_id', 'class_setups.name', 'lessons.instructional_objective as objectives', 'lessons.date')
            ->latest('lessons.id')
            ->first();

        //dd($user);
        return $lesson;
    }

    public function allLessonActivities(): Collection
    {
        $activity = Activity::with('lessonPart')->get();

        return $activity;
    }

    public function lessonsPerUnit(int $unitId): Collection
    {
        $lessons = Lesson::where("unit_id", "=", $unitId)->get();
        return $lessons;
    }
    public function lessonActivitiesPerUser(int $lessonId): Collection
    {
        $user = Auth::id();
        $lessonActivities = Activity::join('lesson_parts', 'lesson_parts.id', '=', 'activities.lesson_part_id')
                                    ->join('lessons','lesson_parts.lesson_id','=','lessons.id')
                                    ->join('units','lessons.unit_id','=','units.id')
                                    ->join('subjects', 'subjects.id', '=', 'units.subject_id')
                                    ->join('class_setups', 'class_setups.id', '=', 'subjects.class_id')
                                    ->where('class_setups.user_id', '=', $user)
                                    ->where('lessons.id','=',$lessonId)
                                    ->select('activities.id as activity_id','lessons.id', 'lessons.title', 'lessons.topic_area', 'units.title as unitName', 'lessons.date', 'lessons.instructional_objective','lesson_parts.type','lesson_parts.duration as partDuration','activities.teacher_activities','activities.learner_activities','activities.competences')
                                    ->select('lessons.id', 'lessons.title', 'lessons.topic_area', 'units.title as unitName', 'lessons.date', 'lessons.instructional_objective','lesson_parts.type','lesson_parts.duration as partDuration','activities.teacher_activities','activities.learner_activities','activities.competences')
                                    ->get();

        return $lessonActivities;
    }

    public function lessonActivityPerUser(int $lessonId)
    {
        $user = Auth::id();
        $lessonActivity = Activity::join('lesson_parts', 'lesson_parts.id', '=', 'activities.lesson_part_id')
                                    ->join('lessons','lesson_parts.lesson_id','=','lessons.id')
                                    ->join('units','lessons.unit_id','=','units.id')
                                    ->join('subjects', 'subjects.id', '=', 'units.subject_id')
                                    ->join('class_setups', 'class_setups.id', '=', 'subjects.class_id')
                                    ->where('class_setups.user_id', '=', $user)
                                    ->where('lessons.id','=',$lessonId)
                                    ->select('activities.id as activity_id','lessons.id', 'lessons.title', 'lessons.topic_area', 'units.title as unitName', 'lessons.date', 'lessons.instructional_objective','lesson_parts.type','lesson_parts.duration as partDuration','activities.teacher_activities','activities.learner_activities','activities.competences')
                                    ->first();

        return $lessonActivity;
    }
    public function updateTeacherActivity(UpdateTeacherActivitiesDto $data, int $id): Activity
    {
        $activity = Activity::find($id);
        if(is_null($activity)){
            throw new ItemNotFoundException("Activity not found");
        }
        $teacher_activities = $data->teacher_activities;

        try {
            $activity->update([
                "teacher_activities" => $teacher_activities,
            ]);

            return $activity;

        } catch (Exception $th) {

            Log::error("Failed to update Teacher Activity ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }


    public function updateLesson(UpdateLessonDto $data, int $id): Lesson
    {
        $lesson = Lesson::find($id);
        if (is_null($lesson)) {
            throw new ItemNotFoundException("The Lesson does not exist");
        }

        $title = $data->lessonTitle;
        $unitId = $data->unitId;
        $topic_area = $data->topicArea;
        $duration = $data->duration;
        $date = $data->lessonDate;
        $objective = $data->instructionalObjective;
        $knowledge = $data->knowledge;
        $skills = $data->skills;
        $attitudes = $data->attitudeValues;
        $materials = $data->teachingMaterial;
        $description = $data->description;
        $reference = $data->reference;


        try {
            $lesson->update([
                "title" => $title,
                "unit_id" => $unitId,
                "topic_area" => $topic_area,
                "duration" => $duration,
                "date" => $date,
                "instructional_objective" => $objective,
                "knowledge_and_understanding" => $knowledge,
                "skills" => $skills,
                "attitudes_and_values" => $attitudes,
                "teaching_materials" => $materials,
                "description_of_teaching" => $description,
                "reference" => $reference,
            ]);

            return $lesson;
        } catch (Exception $th) {

            Log::error("Failed to update Lesson ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }
    public function destroyLesson(int $id): bool
    {
        $lesson = Lesson::find($id);
        if (is_null($lesson)) {
            throw new ItemNotFoundException("The Lesson does not exist");
        }

        return $lesson->delete();
    }
}