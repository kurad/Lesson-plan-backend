<?php

namespace App\Http\Controllers;

use App\Http\Requests\LearnerActivities\CreateLearnerActivityRequest;
use App\Http\Requests\LearnerActivities\UpdateLearnerActivityRequest;
use App\Services\LessonLearnerActivitiesService;
use Exception;
use Illuminate\Support\Facades\Response;

class LessonPartLearnerActivityController extends Controller
{

    public function __construct(public LessonLearnerActivitiesService $learnerActivities)
    {
    }

    public function index()
    {

        $result = $this->learnerActivities->allLearnerActivities()->toArray();

        return Response::json($result);
    }

    public function store(CreateLearnerActivityRequest $request)
    {
        try {

            $lessonPart = $this->learnerActivities->createLearnerActivity($request->dto);
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
            $lessonPart = $this->learnerActivities->getLearnerActivity($id);
            return Response::json($lessonPart);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function getLearnerActivities(int $id)
    {
        try {
            $activities = $this->learnerActivities->getLearnerActivities($id);
            return Response::json($activities);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function update(UpdateLearnerActivityRequest $request, int $id)
    {
        try {
            $lessonPart = $this->learnerActivities->updateLearnerActivity($request->dto, $id);
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
            $lessonPart = $this->learnerActivities->destroyLearnerActivity($id);
            return Response::json($lessonPart);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
}
