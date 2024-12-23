<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Interfaces\EmployeeRepositoryInterface;
use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Resources\EmployeeResource;


class EmployeeController extends Controller
{
    private EmployeeRepositoryInterface $EmployeeRepository;

    public function __construct(EmployeeRepositoryInterface $userRepository)
    {
        $this->EmployeeRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $query = Employee::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('empNo')) {
            $query->where('empNo', $request->input('empNo'));
        }
        if ($request->has('name')) {
            $query->where('name', $request->input('name'));
        }
        if ($request->has('fullname')) {
            $query->where('fullname', $request->input('fullname'));
        }
        if ($request->has('company')) {
            $query->where('company', $request->input('company'));
        }
        if ($request->has('department')) {
            $query->where('department', $request->input('department'));
        }
        if ($request->has('section')) {
            $query->where('section', $request->input('section'));
        }
        if ($request->has('position')) {
            $query->where('position', $request->input('position'));
        }
        if ($request->has('supervisor')) {
            $query->where('supervisor', $request->input('supervisor'));
        }
        if ($request->has('dateJoined')) {
            $query->where('dateJoined', $request->input('dateJoined'));
        }
        if ($request->has('dateTerminated')) {
            $query->where('dateTerminated', $request->input('dateTerminated'));
        }
        if ($request->has('resigned')) {
            $query->where('resigned', $request->input('resigned'));
        }
        if ($request->has('empGroup')) {
            $query->where('empGroup', $request->input('empGroup'));
        }
        if ($request->has('empCode')) {
            $query->where('empCode', $request->input('empCode'));
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
        return response()->json(["data" => EmployeeResource::collection($results)]);
    }

    public function store(CreateEmployeeRequest $request): JsonResponse
    {
        $request->merge(['created_by' => Auth::id(), 'updated_by' => Auth::id()]);
        $data = Employee::create($request->all());
        return response()->json(new EmployeeResource($data));
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
        ])->findOrFail($id)->$query->get();
        return response()->json(EmployeeResource::collection($data));
    }

    public function update(CreateEmployeeRequest $request, $id): JsonResponse
    {
        $request->merge(['updated_by' => Auth::id()]);
        $newData = $request->except(["id", "created_at"]);
        $data = $this->EmployeeRepository->updateEmployee($id, (array) $newData);
        return response()->json(new EmployeeResource($data));
    }

    public function destroy($id)
    {
        $post = Employee::find($id);
        $post->delete();
        return response()->json(['message' => 'Employee deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE employees")
        ]);
    }
}
