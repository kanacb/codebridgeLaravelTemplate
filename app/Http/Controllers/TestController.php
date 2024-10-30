<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Test;
use App\Interfaces\TestRepositoryInterface;
use App\Http\Requests\CreateTestRequest;

class TestController extends Controller
{
    private TestRepositoryInterface $TestRepository;

    public function __construct(TestRepositoryInterface $userRepository) 
    {
        $this->TestRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->TestRepository->getAllTests()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->TestRepository->getAllTests()
        ]);
    }

    public function store(CreateTestRequest $request): JsonResponse 
    {
        $data = Test::create($request->validated());
        return response()->json(['message' => 'Test created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Test::query();

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

        $data = Test::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateTestRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->TestRepository->updateTest( $id, (array) $newData);
        return response()->json(['message' => 'Test updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = Test::find($id);
        $post->delete();
        return response()->json(['message' => 'Test deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE tests")
        ]);
    }

}
