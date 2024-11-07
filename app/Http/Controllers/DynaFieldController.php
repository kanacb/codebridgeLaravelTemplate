<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\DynaField;
use App\Interfaces\DynaFieldRepositoryInterface;
use App\Http\Requests\CreateDynaFieldRequest;
use App\Http\Resources\DynaFieldResource;

class DynaFieldController extends Controller
{
    private DynaFieldRepositoryInterface $DynaFieldRepository;

    public function __construct(DynaFieldRepositoryInterface $userRepository) 
    {
        $this->DynaFieldRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse 
    {
        $query = DynaField::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('dynaLoader')) {$query->where('dynaLoader', $request->input('dynaLoader'));}
if ($request->has('from')) {$query->where('from', $request->input('from'));}
if ($request->has('fromType')) {$query->where('fromType', $request->input('fromType'));}
if ($request->has('to2')) {$query->where('to2', $request->input('to2'));}
if ($request->has('toType')) {$query->where('toType', $request->input('toType'));}
if ($request->has('fromRefService')) {$query->where('fromRefService', $request->input('fromRefService'));}
if ($request->has('toRefService')) {$query->where('toRefService', $request->input('toRefService'));}
if ($request->has('fromIdentityFieldName')) {$query->where('fromIdentityFieldName', $request->input('fromIdentityFieldName'));}
if ($request->has('toIdentityFieldName')) {$query->where('toIdentityFieldName', $request->input('toIdentityFieldName'));}
if ($request->has('fromRelationship')) {$query->where('fromRelationship', $request->input('fromRelationship'));}
if ($request->has('toRelationship')) {$query->where('toRelationship', $request->input('toRelationship'));}
if ($request->has('duplicates')) {$query->where('duplicates', $request->input('duplicates'));}

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
        return response()->json(["data" => DynaFieldResource::collection($results)]);
    }

    public function store(CreateDynaFieldRequest $request): JsonResponse 
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
        $data = DynaField::create($request->validated());
        return response()->json(new DynaFieldResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = DynaField::query();

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

        $data = DynaField::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id)->$query->get();
        return response()->json(DynaFieldResource::collection($data));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $newData = $request->except(["created_at","updated_at"]);
        $data = $this->DynaFieldRepository->updateDynaField( $id, (array) $newData);
        return response()->json(new DynaFieldResource($data));
    }

    public function destroy($id)
    {
        $post = DynaField::find($id);
        $post->delete();
        return response()->json(['message' => 'DynaField deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE dynaFields")
        ]);
    }

}
