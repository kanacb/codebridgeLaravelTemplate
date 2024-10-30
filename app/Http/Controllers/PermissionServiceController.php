<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PermissionService;
use App\Interfaces\PermissionServiceRepositoryInterface;
use App\Http\Requests\CreatePermissionServiceRequest;

class PermissionServiceController extends Controller
{
    private PermissionServiceRepositoryInterface $PermissionServiceRepository;

    public function __construct(PermissionServiceRepositoryInterface $userRepository) 
    {
        $this->PermissionServiceRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->PermissionServiceRepository->getAllPermissionServices()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->PermissionServiceRepository->getAllPermissionServices()
        ]);
    }

    public function store(CreatePermissionServiceRequest $request): JsonResponse 
    {
        $data = PermissionService::create($request->validated());
        return response()->json(['message' => 'PermissionService created successfully', 'data' => $data]);
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
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreatePermissionServiceRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->PermissionServiceRepository->updatePermissionService( $id, (array) $newData);
        return response()->json(['message' => 'PermissionService updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = PermissionService::find($id);
        $post->delete();
        return response()->json(['message' => 'PermissionService deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE permissionServices")
        ]);
    }

}
