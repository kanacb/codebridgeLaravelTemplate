<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\DepartmentHOD;
use App\Interfaces\DepartmentHODRepositoryInterface;
use App\Http\Requests\CreateDepartmentHODRequest;
use App\Http\Resources\DepartmentHODResource;

class DepartmentHODController extends Controller
{
    private DepartmentHODRepositoryInterface $DepartmentHODRepository;

    public function __construct(DepartmentHODRepositoryInterface $userRepository) 
    {
        $this->DepartmentHODRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse 
    {
        $query = DepartmentHOD::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('name')) {$query->where('name', $request->input('name'));}

        // Handle pagination
        $limit = $request->input('$limit', 10);  // Default to 10 items
        $skip = $request->input('$skip', 0);  // Default to no offset

        $query->limit($limit)->offset($skip);

        // Handle sorting
        if ($request->has('$sort')) {
            foreach ($request->input('$sort') as $field => $order) {
                if($field === "createdAt") $field = "created_at";
                if($field === "updatedAt") $field = "updated_at";
                if($field === "_id") $field = "id";
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
        return response()->json(["data" => DepartmentHODResource::collection($results)]);
    }

    public function store(CreateDepartmentHODRequest $request): JsonResponse 
    {
        // if objectid
        // if (is_array($request->input('name'))) {
        //     $request->merge([
        //         'name' => $request->input('name')->_id
        //     ]);
        // }
        //if date
        // if (is_array($request->input('purchasedDate'))) {
        //     $request->merge([
        //         'purchasedDate' => $request->input('purchasedDate')
        //     ]);
        // }
        $data = DepartmentHOD::create($request->validated());
        return response()->json(new DepartmentHODResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = DepartmentHOD::query();

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

        $data = DepartmentHOD::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id)->$query->get();
        return response()->json(DepartmentHODResource::collection($data));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $newData = $request->except(["created_at","updated_at"]);
        $data = $this->DepartmentHODRepository->updateDepartmentHOD( $id, (array) $newData);
        return response()->json(new DepartmentHODResource($data));
    }

    public function destroy($id)
    {
        $post = DepartmentHOD::find($id);
        $post->delete();
        return response()->json(['message' => 'DepartmentHOD deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE departmentHOD")
        ]);
    }

}
