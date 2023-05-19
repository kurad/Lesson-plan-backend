<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\ActivitiesService;
use Illuminate\Support\Facades\Response;
use App\DTO\LessonParts\UpdateLessonPartDto;
use App\Http\Requests\LessonActivity\CreateLessonActivityRequest;

class ActivitiesController extends Controller
{
    public function __construct(public ActivitiesService $lessonActivities)
    {
    }

    public function index()
    {
        $result = $this->lessonActivities->allLessonActivities()->toArray();

        return Response::json($result);
    }

    public function store(CreateLessonActivityRequest $request)
    {
        try {

            $lessonActivity = $this->lessonActivities->createLessonActivity($request->dto);
            return Response::json($lessonActivity);
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
            $lessonActivities = $this->lessonActivities->getLessonActivity($id);
            return Response::json($lessonActivities);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    //  public function lessonPartPerLesson(int $id)
    // {
    //     try {
    //         $lessonPart = $this->lessonActivities->lessonPartsPerLesson($id);
    //         return Response::json($lessonPart);
    //     } catch (Exception $th) {

    //         return Response::json([
    //             "error" => $th->getMessage(),
    //             "status" => 422
    //         ], 422);
    //     }
    // }

    // public function checkLessonParts(int $id)
    // {
    //     try {
    //         $lessonPart = $this->lessonActivities->checkLessonParts($id);
    //         return Response::json($lessonPart);
    //     } catch (Exception $th) {

    //         return Response::json([
    //             "error" => $th->getMessage(),
    //             "status" => 422
    //         ], 422);
    //     }
    // }
    // public function getLessonPart(int $id)
    // {
    //     try {
    //         $lessonPart = $this->lessonActivities->getLessonParts($id);
    //         return Response::json($lessonPart);
    //     } catch (Exception $th) {

    //         return Response::json([
    //             "error" => $th->getMessage(),
    //             "status" => 422
    //         ], 422);
    //     }
    // }
    // public function checkLessonParts(int $id)
    // {
    //     try {
    //         $lessonPart = $this->lessonActivities->checkLessonParts($id);
    //         return Response::json($lessonPart);
    //     } catch (Exception $th) {

    //         return Response::json([
    //             "error" => $th->getMessage(),
    //             "status" => 422
    //         ], 422);
    //     }
    // }
    // public function getLessonPart(int $id)
    // {
    //     try {
    //         $lessonPart = $this->lessonActivities->getLessonParts($id);
    //         return Response::json($lessonPart);
    //     } catch (Exception $th) {

    //         return Response::json([
    //             "error" => $th->getMessage(),
    //             "status" => 422
    //         ], 422);
    //     }
    // }

    public function lessonActivities()
    {
        try {
            $lessonActivities = $this->lessonActivities->allLessonActivities();
            return Response::json($lessonActivities);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
    public function lessonActivitiesPerUser(int $lessonId)
    {
        try {
            $lessonActivities = $this->lessonActivities->lessonActivitiesPerUser($lessonId);
            return Response::json($lessonActivities);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }



    // public function lessonPartsActivities(int $id)
    // {
    //     try {
    //         $lessonPart = $this->lessonActivities->lessonPartsActivities($id);
    //         return Response::json($lessonPart);
    //     } catch (Exception $th) {

    //         return Response::json([
    //             "error" => $th->getMessage(),
    //             "status" => 422
    //         ], 422);
    //     }
    // }
    // public function update(UpdateLessonPartDto $request, int $id)
    // {
    //     try {
    //         $lessonPart = $this->lessonActivities->updateLessonPart($request->dto, $id);
    //         return Response::json($lessonPart);
    //     } catch (Exception $th) {

    //         return Response::json([
    //             "error" => $th->getMessage(),
    //             "status" => 422
    //         ], 422);
    //     }
    // }


    // public function lessonPartsActivities(int $id)
    // {
    //     try {
    //         $lessonPart = $this->lessonActivities->lessonPartsActivities($id);
    //         return Response::json($lessonPart);
    //     } catch (Exception $th) {

    //         return Response::json([
    //             "error" => $th->getMessage(),
    //             "status" => 422
    //         ], 422);
    //     }
    // }
    // public function update(UpdateLessonPartDto $request, int $id)
    // {
    //     try {
    //         $lessonPart = $this->lessonActivities->updateLessonPart($request->dto, $id);
    //         return Response::json($lessonPart);
    //     } catch (Exception $th) {

    //         return Response::json([
    //             "error" => $th->getMessage(),
    //             "status" => 422
    //         ], 422);
    //     }
    // }

    

    // public function destroy(int $id)
    // {
    //     try {
    //         $lessonPart = $this->lessonActivities->destroyLessonPart($id);
    //         return Response::json($lessonPart);
    //     } catch (Exception $th) {

    //         return Response::json([
    //             "error" => $th->getMessage(),
    //             "status" => 422
    //         ], 422);
    //     }
    // }
}