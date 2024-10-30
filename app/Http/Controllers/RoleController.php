<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Role;
use App\Interfaces\RoleRepositoryInterface;
use App\Http\Requests\CreateRoleRequest;

class RoleController extends Controller
{
    private RoleRepositoryInterface $RoleRepository;

    public function __construct(RoleRepositoryInterface $userRepository) 
    {
        $this->RoleRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->RoleRepository->getAllRoles()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->RoleRepository->getAllRoles()
        ]);
    }

    public function store(CreateRoleRequest $request): JsonResponse 
    {
        $data = Role::create($request->validated());
        return response()->json(['message' => 'Role created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Role::query();

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

        $data = Role::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateRoleRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->RoleRepository->updateRole( $id, (array) $newData);
        return response()->json(['message' => 'Role updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = Role::find($id);
        $post->delete();
        return response()->json(['message' => 'Role deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE roles")
        ]);
    }

}
