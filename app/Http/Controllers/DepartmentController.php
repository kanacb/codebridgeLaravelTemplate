<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Department;
use App\Interfaces\DepartmentRepositoryInterface;
use App\Http\Requests\CreateDepartmentRequest;

class DepartmentController extends Controller
{
    private DepartmentRepositoryInterface $DepartmentRepository;

    public function __construct(DepartmentRepositoryInterface $userRepository) 
    {
        $this->DepartmentRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->DepartmentRepository->getAllDepartments()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->DepartmentRepository->getAllDepartments()
        ]);
    }

    public function store(CreateDepartmentRequest $request): JsonResponse 
    {
        $data = Department::create($request->validated());
        return response()->json(['message' => 'Department created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Department::query();

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

        $data = Department::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateDepartmentRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->DepartmentRepository->updateDepartment( $id, (array) $newData);
        return response()->json(['message' => 'Department updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = Department::find($id);
        $post->delete();
        return response()->json(['message' => 'Department deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE departments")
        ]);
    }

}
