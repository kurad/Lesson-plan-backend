<?php

namespace App\Http\Controllers;

use App\Http\Requests\Unit\CreateUnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use App\Services\UnitService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UnitController extends Controller
{
    public function __construct(public UnitService $unitService)
    {
    }

    public function index()
    {
        $units = $this->unitService->allUnits()->toArray();

        return Response::json($units);
    }

    public function Units()
    {
        $units = $this->unitService->Units()->toArray();

        return Response::json($units);
    }

    public function store(CreateUnitRequest $request)
    {
        try {

            $unit = $this->unitService->createUnit($request->dto);
            return Response::json($unit);
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
            $unit = $this->unitService->getUnit($id);
            return Response::json($unit);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function subjectsUnit()
    {
        try {
            $units = $this->unitService->unitsPerSubject();
            return Response::json($units);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
    public function unitsPerUser()
    {
        try {
            $units = $this->unitService->unitsPerUser();
            return Response::json($units);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }

    public function update(UpdateUnitRequest $request, int $id)
    {
        try {
            $unit = $this->unitService->updateUnit($request->dto, $id);
            return Response::json($unit);
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
            $unit = $this->unitService->destroyUnit($id);
            return Response::json($unit);
        } catch (Exception $th) {

            return Response::json([
                "error" => $th->getMessage(),
                "status" => 422
            ], 422);
        }
    }
}