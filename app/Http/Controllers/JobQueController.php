<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\JobQue;
use App\Interfaces\JobQueRepositoryInterface;
use App\Http\Requests\CreateJobQueRequest;

class JobQueController extends Controller
{
    private JobQueRepositoryInterface $JobQueRepository;

    public function __construct(JobQueRepositoryInterface $userRepository)
    {
        $this->JobQueRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $query = JobQue::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('name')) {
            $query->where('name', $request->input('name'));
        }
        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }
        if ($request->has('fromService')) {
            $query->where('fromService', $request->input('fromService'));
        }
        if ($request->has('toService')) {
            $query->where('toService', $request->input('toService'));
        }
        if ($request->has('start')) {
            $query->where('start', $request->input('start'));
        }
        if ($request->has('end')) {
            $query->where('end', $request->input('end'));
        }

        // Handle pagination
        $limit = $request->input('$limit', 10);  // Default to 10 items
        $skip = $request->input('$skip', 0);  // Default to no offset

        $query->limit($limit)->offset($skip);

        // Handle sorting
        if ($request->has('$sort')) {
            foreach ($request->input('$sort') as $field => $order) {
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
        return response()->json($results);
    }

    public function store(CreateJobQueRequest $request): JsonResponse
    {
        $data = JobQue::create($request->validated());
        return response()->json(['message' => 'JobQue created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = JobQue::query();

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

        $data = JobQue::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id)->$query->get();
        return response()->json($data);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $newData = $request->except(["created_at", "updated_at"]);
        $data = $this->JobQueRepository->updateJobQue($id, (array) $newData);
        return response()->json(['message' => 'JobQue updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = JobQue::find($id);
        $post->delete();
        return response()->json(['message' => 'JobQue deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE jobQues")
        ]);
    }
}
