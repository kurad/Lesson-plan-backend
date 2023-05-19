<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonCompetence\CreateLessonCompetenceRequest;
use App\Http\Requests\LessonCompetence\UpdateLessonCompetenceRequest;
use App\Services\LessonCompetenceService;
use Exception;
use Illuminate\Support\Facades\Response;

class LessonPartCompetenceController extends Controller
{
    public function __construct(public LessonCompetenceService $lessonCompetence)
    {
    }

    public function index()
    {
        $result = $this->lessonCompetence->allCompetence()->toArray();

        return Response::json($result);
    }

    public function store(CreateLessonCompetenceRequest $request)
    {
        try {

            $lessonPart = $this->lessonCompetence->createLessonCompetence($request->dto);
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
            $lessonPart = $this->lessonCompetence->getLessonCompetence($id);
            return Response::json($lessonPart);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function update(UpdateLessonCompetenceRequest $request, int $id)
    {
        try {
            $lessonPart = $this->lessonCompetence->updateLessonCompetence($request->dto, $id);
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
            $lessonPart = $this->lessonCompetence->destroyLessonCompetence($id);
            return Response::json($lessonPart);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
}
