<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Interfaces\SectionRepositoryInterface;
use App\Http\Requests\CreateSectionRequest;
use App\Http\Resources\SectionResource;

class SectionController extends Controller
{
    private SectionRepositoryInterface $SectionRepository;

    public function __construct(SectionRepositoryInterface $userRepository) 
    {
        $this->SectionRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse 
    {
        $query = Section::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('departmentId')) {$query->where('departmentId', $request->input('departmentId'));}
if ($request->has('name')) {$query->where('name', $request->input('name'));}
if ($request->has('code')) {$query->where('code', $request->input('code'));}
if ($request->has('isDefault')) {$query->where('isDefault', $request->input('isDefault'));}

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
        return response()->json(["data" => SectionResource::collection($results)]);
    }

    public function store(CreateSectionRequest $request): JsonResponse 
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
        $data = Section::create($request->validated());
        return response()->json(new SectionResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Section::query();

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

        $data = Section::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id)->$query->get();
        return response()->json(SectionResource::collection($data));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $newData = $request->except(["created_at","updated_at"]);
        $data = $this->SectionRepository->updateSection( $id, (array) $newData);
        return response()->json(new SectionResource($data));
    }

    public function destroy($id)
    {
        $post = Section::find($id);
        $post->delete();
        return response()->json(['message' => 'Section deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE sections")
        ]);
    }

}
