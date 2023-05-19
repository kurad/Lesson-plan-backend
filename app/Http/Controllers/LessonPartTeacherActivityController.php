<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherActivities\CreateLessonTeacherActivitiesRequest;
use App\Http\Requests\TeacherActivities\UpdateLessonTeacherActivitiesRequest;
use App\Services\LessonTeacherActivitiesService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LessonPartTeacherActivityController extends Controller
{
    public function __construct(public LessonTeacherActivitiesService $teacherActivities)
    {
    }

    public function index()
    {

        $result = $this->teacherActivities->allTeacherActivities()->toArray();

        return Response::json($result);
    }

    public function store(CreateLessonTeacherActivitiesRequest $request)
    {
        try {

            $lessonPart = $this->teacherActivities->createTeacherActivity($request->dto);
            return Response::json($lessonPart);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function show(int $id)
    {
        try {
            $lessonPart = $this->teacherActivities->getTeacherActivity($id);
            return Response::json($lessonPart);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
    public function getTeacherActivities(int $id)
    {
        try {
            $activities = $this->teacherActivities->getTeacherActivities($id);
            return Response::json($activities);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function update(UpdateLessonTeacherActivitiesRequest $request, int $id)
    {
        try {
            $lessonPart = $this->teacherActivities->updateTeacherActivity($request->dto, $id);
            return Response::json($lessonPart);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function destroy(int $id)
    {
        try {
            $lessonPart = $this->teacherActivities->destroyTeacherActivity($id);
            return Response::json($lessonPart);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
}
