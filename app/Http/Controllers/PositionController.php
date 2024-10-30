<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Position;
use App\Interfaces\PositionRepositoryInterface;
use App\Http\Requests\CreatePositionRequest;

class PositionController extends Controller
{
    private PositionRepositoryInterface $PositionRepository;

    public function __construct(PositionRepositoryInterface $userRepository) 
    {
        $this->PositionRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->PositionRepository->getAllPositions()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->PositionRepository->getAllPositions()
        ]);
    }

    public function store(CreatePositionRequest $request): JsonResponse 
    {
        $data = Position::create($request->validated());
        return response()->json(['message' => 'Position created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Position::query();

        // Check for `$populate` parameters
        if ($request->has('$populate')) {
            $populateParams = $request->input('$populate');

            // Initialize an array to hold the relationships and their field constraints
            $relationships = [];

            foreach ($populateParams as $populate) {
                $relationship = $populate['path'];
                $fields = $populate['select'] ?? ['*'];

                // Add the relationship and its fields to the array
                $relationships[$relationship] = function ($query) use ($fields) {
                    $query->select($fields);
                };
            }

            // Apply eager loading with specific fields
            $query->with($relationships);
        }

        $data = Position::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreatePositionRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->PositionRepository->updatePosition( $id, (array) $newData);
        return response()->json(['message' => 'Position updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = Position::find($id);
        $post->delete();
        return response()->json(['message' => 'Position deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE positions")
        ]);
    }

}
