<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\PermissionService;
use App\Interfaces\PermissionServiceRepositoryInterface;
use App\Http\Requests\CreatePermissionServiceRequest;
use App\Http\Resources\PermissionServiceResource;

class PermissionServiceController extends Controller
{
    private PermissionServiceRepositoryInterface $PermissionServiceRepository;

    public function __construct(PermissionServiceRepositoryInterface $userRepository)
    {
        $this->PermissionServiceRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $query = PermissionService::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('profile')) {
            $query->where('profile', $request->input('profile'));
        }
        if ($request->has('service')) {
            $query->where('service', $request->input('service'));
        }
        if ($request->has('read')) {
            $query->where('read', $request->input('read'));
        }
        if ($request->has('readAll')) {
            $query->where('readAll', $request->input('readAll'));
        }
        if ($request->has('updateOwn')) {
            $query->where('updateOwn', $request->input('updateOwn'));
        }
        if ($request->has('updateAll')) {
            $query->where('updateAll', $request->input('updateAll'));
        }
        if ($request->has('deleteOwn')) {
            $query->where('deleteOwn', $request->input('deleteOwn'));
        }
        if ($request->has('deleteAll')) {
            $query->where('deleteAll', $request->input('deleteAll'));
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

    public function store(CreatePermissionServiceRequest $request): JsonResponse
    {
        $data = PermissionService::create($request->validated());
        return response()->json(new PermissionServiceResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = PermissionService::query();

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

        $data = PermissionService::with([
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
        $data = $this->PermissionServiceRepository->updatePermissionService($id, (array) $newData);
        return response()->json(['message' => 'PermissionService updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = PermissionService::find($id);
        $post->delete();
        return response()->json(['message' => 'PermissionService deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE permissionServices")
        ]);
    }
}
