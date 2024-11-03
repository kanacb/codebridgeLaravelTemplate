<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\UserGuide;
use App\Interfaces\UserGuideRepositoryInterface;
use App\Http\Requests\CreateUserGuideRequest;
use App\Http\Resources\UserGuideResource;

class UserGuideController extends Controller
{
    private UserGuideRepositoryInterface $UserGuideRepository;

    public function __construct(UserGuideRepositoryInterface $userRepository)
    {
        $this->UserGuideRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $query = UserGuide::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('serviceName')) {
            $query->where('serviceName', $request->input('serviceName'));
        }
        if ($request->has('expiry')) {
            $query->where('expiry', $request->input('expiry'));
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
        return response()->json(["data" => $results]);
    }

    public function store(CreateUserGuideRequest $request): JsonResponse
    {
        $data = UserGuide::create($request->validated());
        return response()->json(new UserGuideResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = UserGuide::query();

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

        $data = UserGuide::with([
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
        $data = $this->UserGuideRepository->updateUserGuide($id, (array) $newData);
        return response()->json(['message' => 'UserGuide updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = UserGuide::find($id);
        $post->delete();
        return response()->json(['message' => 'UserGuide deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE userGuides")
        ]);
    }
}
