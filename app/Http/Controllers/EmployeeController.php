<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Employee;
use App\Interfaces\EmployeeRepositoryInterface;
use App\Http\Requests\CreateEmployeeRequest;

class EmployeeController extends Controller
{
    private EmployeeRepositoryInterface $EmployeeRepository;

    public function __construct(EmployeeRepositoryInterface $userRepository) 
    {
        $this->EmployeeRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->EmployeeRepository->getAllEmployees()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->EmployeeRepository->getAllEmployees()
        ]);
    }

    public function store(CreateEmployeeRequest $request): JsonResponse 
    {
        $data = Employee::create($request->validated());
        return response()->json(['message' => 'Employee created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Employee::query();

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

        $data = Employee::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateEmployeeRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->EmployeeRepository->updateEmployee( $id, (array) $newData);
        return response()->json(['message' => 'Employee updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = Employee::find($id);
        $post->delete();
        return response()->json(['message' => 'Employee deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE employees")
        ]);
    }

}
