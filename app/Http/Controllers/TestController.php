<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Test;
use App\Interfaces\TestRepositoryInterface;
use App\Http\Requests\CreateTestRequest;
use App\Http\Resources\TestResource;


class TestController extends Controller
{
    private TestRepositoryInterface $TestRepository;

    public function __construct(TestRepositoryInterface $userRepository)
    {
        $this->TestRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $query = Test::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('stack')) {
            $query->where('stack', $request->input('stack'));
        }
        if ($request->has('service')) {
            $query->where('service', $request->input('service'));
        }
        if ($request->has('passed')) {
            $query->where('passed', $request->input('passed'));
        }
        if ($request->has('failed')) {
            $query->where('failed', $request->input('failed'));
        }
        if ($request->has('notes')) {
            $query->where('notes', $request->input('notes'));
        }

        // Handle pagination
        $limit = $request->input('$limit', 10);  // Default to 10 items
        $skip = $request->input('$skip', 0);  // Default to no offset

        $query->limit($limit)->offset($skip);

        // Handle sorting
        if ($request->has('$sort')) {
            foreach ($request->input('$sort') as $field => $order) {
                if ($field === "createdAt") $field = "created_at";
                if ($field === "updatedAt") $field = "updated_at";
                if ($field === "_id") $field = "id";
                $query->orderBy($field, $order == 1 ? 'asc' : 'desc');
            }
        }

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

        // Execute and get the results
        $results = $query->get();

        // Return as a JSON resource (optional)
        return response()->json(["data" => TestResource::collection($results)]);
    }

    public function store(CreateTestRequest $request): JsonResponse
    {
        $request->merge(['created_by' => Auth::id(), 'updated_by' => Auth::id()]);
        $data = Test::create($request->all());
        return response()->json(new TestResource($data));
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
        ])->findOrFail($id)->$query->get();
        return response()->json(TestResource::collection($data));
    }

    public function update(CreateTestRequest $request, $id): JsonResponse
    {
        $request->merge(['updated_by' => Auth::id()]);
        $newData = $request->except(["id", "created_at"]);
        $data = $this->TestRepository->updateTest($id, (array) $newData);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $post = Test::find($id);
        $post->delete();
        return response()->json(['message' => 'Test deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE tests")
        ]);
    }
}
