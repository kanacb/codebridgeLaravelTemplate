<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\DynaLoader;
use App\Interfaces\DynaLoaderRepositoryInterface;
use App\Http\Requests\CreateDynaLoaderRequest;
use App\Http\Resources\DynaLoaderResource;

class DynaLoaderController extends Controller
{
    private DynaLoaderRepositoryInterface $DynaLoaderRepository;

    public function __construct(DynaLoaderRepositoryInterface $userRepository) 
    {
        $this->DynaLoaderRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse 
    {
        $query = DynaLoader::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('from')) {$query->where('from', $request->input('from'));}
if ($request->has('to2')) {$query->where('to2', $request->input('to2'));}
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
        return response()->json(["data" => DynaLoaderResource::collection($results)]);
    }

    public function store(CreateDynaLoaderRequest $request): JsonResponse 
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
        $data = DynaLoader::create($request->validated());
        return response()->json(new DynaLoaderResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = DynaLoader::query();

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

        $data = DynaLoader::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id)->$query->get();
        return response()->json(DynaLoaderResource::collection($data));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $newData = $request->except(["created_at","updated_at"]);
        $data = $this->DynaLoaderRepository->updateDynaLoader( $id, (array) $newData);
        return response()->json(new DynaLoaderResource($data));
    }

    public function destroy($id)
    {
        $post = DynaLoader::find($id);
        $post->delete();
        return response()->json(['message' => 'DynaLoader deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE dynaLoader")
        ]);
    }

}
