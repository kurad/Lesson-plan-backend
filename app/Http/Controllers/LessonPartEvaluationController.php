<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonEvaluation\CreateLessonEvaluationRequest;
use App\Http\Requests\LessonEvaluation\UpdateLessonEvaluationRequest;
use App\Services\LessonEvaluationService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class LessonPartEvaluationController extends Controller
{
    public function __construct(public LessonEvaluationService $evaluationService)
    {
    }

    public function index()
    {
        $result = $this->evaluationService->allEvaluation()->toArray();

        return Response::json($result);
    }

    public function store(CreateLessonEvaluationRequest $request)
    {
        try {

            $evaluation = $this->evaluationService->createLessonEvaluation($request->dto);
            return Response::json($evaluation);
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
            $evaluation = $this->evaluationService->getLessonEvaluation($id);
            return Response::json($evaluation);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function evaluationPerLesson(int $id)
    {
        try {
            $evaluations = $this->evaluationService->evaluationPerLesson($id);
            return Response::json($evaluations);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function lessonEvaluationPerUser(int $lessonId)
    {
        try {
            $lessonEvaluation = $this->evaluationService->lessonEvaluationPerUser($lessonId);
            return Response::json($lessonEvaluation);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function update(UpdateLessonEvaluationRequest $request, int $id)
    {
        try {
            $evaluation = $this->evaluationService->updateLessonEvaluation($request->dto, $id);
            return Response::json($evaluation);
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
            $evaluation = $this->evaluationService->destroyLessonEvaluation($id);
            return Response::json($evaluation);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
}
