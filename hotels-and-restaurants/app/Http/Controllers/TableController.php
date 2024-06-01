<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableRequest;
use App\Services\TableService;
use Illuminate\Http\JsonResponse;

class TableController extends Controller
{
    private TableService $service;

    public function __construct(TableService $tableService)
    {
        $this->service = $tableService;
    }

    public function index(int $restaurantId): JsonResponse
    {
        $tables = $this->service->index($restaurantId);

        return response()->json([
            'message' => 'Tables retrieved',
            'data' => $tables
        ]);
    }

    public function show(int $restaurantId, int $id): JsonResponse
    {
        $tables = $this->service->show($restaurantId, $id);

        return response()->json([
            'message' => 'Tables retrieved',
            'data' => $tables
        ]);
    }

    public function store(int $restaurantId, TableRequest $request): JsonResponse
    {
        $params = $request->all();

        $newTable = $this->service->store($restaurantId, $params);

        return response()->json([
            'message' => 'Table created',
            'data' => $newTable
        ], 201);
    }

    public function update(int $restaurantId, TableRequest $request, int $id): JsonResponse
    {
        $params = $request->all();

        $updatedTable = $this->service->update($restaurantId, $id, $params);

        return response()->json([
            'message' => 'Table updated',
            'data' => $updatedTable
        ]);
    }

    public function destroy(int $restaurantId, int $id): JsonResponse
    {
        $deletedTable = $this->service->destroy($restaurantId, $id);

        return response()->json([
            'message' => 'Table deleted',
            'data' => $deletedTable
        ]);
    }
}
