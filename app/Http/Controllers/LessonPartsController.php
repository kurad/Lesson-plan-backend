<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\LessonPartService;
use App\Services\LessonPartsService;
use Illuminate\Support\Facades\Response;
use App\DTO\LessonParts\UpdateLessonPartDto;
use App\Http\Requests\LessonPart\CreateLessonPartRequest;
use App\Http\Requests\LessonPart\UpdateLessonPartRequest;

class LessonPartsController extends Controller
{
    public function __construct(public LessonPartsService $lessonParts)
    {
    }

    public function index()
    {
        $result = $this->lessonParts->allLessonParts()->toArray();

        return Response::json($result);
    }

    public function store(CreateLessonPartRequest $request)
    {
        try {

            $lessonPart = $this->lessonParts->createLessonPart($request->dto);
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
            $lessonPart = $this->lessonParts->getLessonPart($id);
            return Response::json($lessonPart);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
    public function lessonPartsPerOneLesson(int $id)
    {
        try {
            $lessonPart = $this->lessonParts->lessonPartsPerOneLesson($id);
            return Response::json($lessonPart);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function lessonPartPerLesson(int $id)
    
    {
        try {
            $lessonPart = $this->lessonParts->lessonPartsPerLesson($id);
            return Response::json($lessonPart);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

     public function lessonPartsActivities(int $id)
    {
        try {
            $lessonPart = $this->lessonParts->lessonPartsActivities($id);
            return Response::json($lessonPart);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function update(UpdateLessonPartRequest $request, int $id)

    {
        try {
            $lessonPart = $this->lessonParts->updateLessonPart($request->dto, $id);
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
            $lessonPart = $this->lessonParts->destroyLessonPart($id);
            return Response::json($lessonPart);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
}