<?php
namespace App\Services;

use Exception;
use App\Models\Unit;
use App\Models\Lesson;
use App\Models\Activity;
use Barryvdh\DomPDF\PDF;
use App\Services\AbstractService;
use App\DTO\Lesson\CreateLessonDto;
use App\DTO\Lesson\UpdateLessonDto;
use App\Exceptions\UknownException;
use Illuminate\Support\Facades\Log;
use App\Models\LessonPartEvaluation;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ItemNotFoundException;
use Illuminate\Database\Eloquent\Collection;

class LessonsService extends AbstractService
{
    public function __construct(private  PDF $pdf) {
    }
    /**
     * @throws Exception
     */
    public function createLesson(CreateLessonDto $data): Lesson
    {
        $title = $data->title;
        $unitId = $data->unitId;
        $topicArea = $data->topicArea;
        $duration = $data->duration;
        $date =  $data->lessonDate;
        $instructions = $data->instructions;
        $knowledge = $data->knowledge;
        $skills = $data->skills;
        $attitudes = $data->attitudes;
        $materials = $data->materials;
        $description = $data->description;
        $reference = $data->reference;
        $unit = Unit::find($unitId);
        if (is_null($unit)) {
            throw new ItemNotFoundException("The unit does not exist");
        }
        try {
            $lesson = Lesson::create([
                "title" => $title,
                "unit_id" => $unit->id,
                "topic_area" => $topicArea,
                "duration" => $duration,
                "date" => $date,
                "instructional_objective" => $instructions,
                "knowledge_and_understanding" => $knowledge,
                "skills" => $skills,
                "attitudes_and_values" => $attitudes,
                "teaching_materials" => $materials,
                "description_of_teaching" => $description,
                "reference" => $reference,
            ]);
            return $lesson;
        } catch (Exception $th) {
            Log::error("Failed to create Lesson ", [
                "message" => $th->getMessage(),
                "function" => __FUNCTION__,
                "class" => __CLASS__,
                "trace" => $th->getTrace()
            ]);
            throw new UknownException("Sorry, there were some issues, contact the system admin");
        }
    }
    public function getLesson(int $id): ?Lesson
    {
        $lesson = Lesson::find($id);
        if (is_null($lesson)) {
            throw new ItemNotFoundException("Sorry, Lesson can not be found");
        }
        return $lesson;
    }
    public function latestLesson()
    {
        $latestLesson = Lesson::with('unit')->latest()->first();
        return $latestLesson;
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
        $lesson = Lesson::join('units','units.id','=','lessons.unit_id')
                        ->join('subjects','subjects.id','=','units.subject_id')
                        ->join('class_setups','class_setups.id','=','subjects.class_id')
                        ->where('class_setups.user_id','=', $user)
                        ->select('lessons.id','lessons.title','lessons.topic_area','lessons.duration','lessons.date','lessons.unit_id','class_setups.name','lessons.instructional_objective as objectives','lessons.date')
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
        $lesson = Lesson::join('units','units.id','=','lessons.unit_id')
                        ->join('subjects','subjects.id','=','units.subject_id')
                        ->join('class_setups','class_setups.id','=','subjects.class_id')
                        ->where('class_setups.user_id','=', $user)
                        ->where('lessons.id','=',$lessonId)
                        ->select('lessons.id','lessons.title','lessons.topic_area','lessons.duration','lessons.date','lessons.unit_id','class_setups.name','lessons.instructional_objective as objectives','lessons.date')
                        ->latest('lessons.id')
                        ->first();
                       
                        //dd($user);
        return $lesson;
    }
    public function allLessons(): Collection
    {
        $lessons = Lesson::with('unit')->get();
        return $lessons;
    }
    public function lessonsPerUnit(int $unitId): Collection
    {
        $lessons = Lesson::where("unit_id", "=", $unitId)->get();
        return $lessons;
    }
    public function lessonsPerUser(): Collection
    {
        $user = Auth::id();
        $lessons = Lesson::join('units', 'units.id', '=', 'lessons.unit_id')
            ->join('subjects', 'subjects.id', '=', 'units.subject_id')
            ->join('class_setups', 'class_setups.id', '=', 'subjects.class_id')
            ->where('class_setups.user_id', '=', $user)
            //->select('lessons.title','lessons.topic_area')
            ->get(['lessons.id', 'lessons.title', 'lessons.topic_area', 'units.title as unitName', 
            'lessons.date', 'lessons.instructional_objective', 'class_setups.name as className']);
        $lessons = Lesson::join('units','units.id','=','lessons.unit_id')
                        ->join('subjects','subjects.id','=','units.subject_id')
                        ->join('class_setups','class_setups.id','=','subjects.class_id')
                        ->where('class_setups.user_id','=', $user)
                        //->select('lessons.title','lessons.topic_area')
                        ->get(['lessons.id','lessons.title','lessons.topic_area','units.title as unitName','lessons.date','lessons.instructional_objective']);
                        
        return $lessons;
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
    public function lessonPlanPDF(int $lessonId)
    {
        
        $lessons = Activity::join('lesson_parts', 'lesson_parts.id', '=', 'activities.lesson_part_id')
                                    //->join('lesson_part_evaluations','lesson_parts.id','=','lesson_part_evaluations.lesson_part_id')
                                    ->join('lessons','lesson_parts.lesson_id','=','lessons.id')
                                    ->join('units','lessons.unit_id','=','units.id')
                                    ->join('subjects', 'subjects.id', '=', 'units.subject_id')
                                    ->join('class_setups', 'class_setups.id', '=', 'subjects.class_id')
                                    ->join('users','class_setups.user_id','=','users.id')
                                    //->where('class_setups.user_id', '=', $user)
                                    ->where('lessons.id','=',$lessonId)
                                    ->select('lessons.id', 'lessons.title as lessonTitle','lessons.duration', 'lessons.topic_area', 'units.title as unitName', 'lessons.date', 'lessons.instructional_objective','lessons.knowledge_and_understanding','lessons.skills','lessons.attitudes_and_values','lessons.teaching_materials','lessons.description_of_teaching','lessons.reference','lesson_parts.type','lesson_parts.duration as partDuration','activities.teacher_activities','activities.learner_activities','activities.competences','users.l_name','users.f_name','subjects.name as subjectName','class_setups.name as className','class_setups.learner_with_SEN','units.title as unitName','units.unit_no','units.key_unit_competence','class_setups.location')
                                    ->first();
        $lessonParts = Activity::join('lesson_parts', 'lesson_parts.id', '=', 'activities.lesson_part_id')
                                    ->join('lessons','lesson_parts.lesson_id','=','lessons.id')
                                    ->join('units','lessons.unit_id','=','units.id')
                                    ->join('subjects', 'subjects.id', '=', 'units.subject_id')
                                    ->join('class_setups', 'class_setups.id', '=', 'subjects.class_id')
                                    ->join('users','class_setups.user_id','=','users.id')
                                    ->where('lessons.id','=',$lessonId)
                                    ->select('lesson_parts.type','lesson_parts.duration','activities.learner_activities','activities.teacher_activities','activities.competences')
                                    ->get();
        $evaluation = LessonPartEvaluation::join('lesson_parts', 'lesson_parts.id', '=', 'lesson_part_evaluations.lesson_part_id')
            ->join('lessons', 'lessons.id', '=', 'lesson_parts.lesson_id')
            ->where("lessons.id", "=", $lessonId)
            ->select('lesson_part_evaluations.content')
            ->first();
        $pdf = $this->pdf->loadView('pdf', ['lessons'=> $lessons, 'lessonParts'=>$lessonParts, 'evaluation'=>$evaluation]);
        //dd($pdf);
        return $pdf;

    }
}