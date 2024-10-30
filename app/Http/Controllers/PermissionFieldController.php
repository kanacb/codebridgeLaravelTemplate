<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PermissionField;
use App\Interfaces\PermissionFieldRepositoryInterface;
use App\Http\Requests\CreatePermissionFieldRequest;

class PermissionFieldController extends Controller
{
    private PermissionFieldRepositoryInterface $PermissionFieldRepository;

    public function __construct(PermissionFieldRepositoryInterface $userRepository) 
    {
        $this->PermissionFieldRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->PermissionFieldRepository->getAllPermissionFields()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->PermissionFieldRepository->getAllPermissionFields()
        ]);
    }

    public function store(CreatePermissionFieldRequest $request): JsonResponse 
    {
        $data = PermissionField::create($request->validated());
        return response()->json(['message' => 'PermissionField created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = PermissionField::query();

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

        $data = PermissionField::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreatePermissionFieldRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->PermissionFieldRepository->updatePermissionField( $id, (array) $newData);
        return response()->json(['message' => 'PermissionField updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = PermissionField::find($id);
        $post->delete();
        return response()->json(['message' => 'PermissionField deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE permissionFields")
        ]);
    }

}
