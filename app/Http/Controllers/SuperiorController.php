<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Superior;
use App\Interfaces\SuperiorRepositoryInterface;
use App\Http\Requests\CreateSuperiorRequest;
use App\Http\Resources\SuperiorResource;


class SuperiorController extends Controller
{
    private SuperiorRepositoryInterface $SuperiorRepository;

    public function __construct(SuperiorRepositoryInterface $userRepository)
    {
        $this->SuperiorRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $query = Superior::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('superior')) {
            $query->where('superior', $request->input('superior'));
        }
        if ($request->has('subordinate')) {
            $query->where('subordinate', $request->input('subordinate'));
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
        return response()->json(["data" => SuperiorResource::collection($results)]);
    }

    public function store(CreateSuperiorRequest $request): JsonResponse
    {
        $request->merge(['created_by' => Auth::id(), 'updated_by' => Auth::id()]);
        $data = Superior::create($request->all());
        return response()->json(new SuperiorResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Superior::query();

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

        $data = Superior::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id)->$query->get();
        return response()->json(SuperiorResource::collection($data));
    }

    public function update(CreateSuperiorRequest $request, $id): JsonResponse
    {
        $request->merge(['updated_by' => Auth::id()]);
        $newData = $request->except(["id", "created_at"]);
        $data = $this->SuperiorRepository->updateSuperior($id, (array) $newData);
        return response()->json(new SuperiorResource($data));
    }

    public function destroy($id)
    {
        $post = Superior::find($id);
        $post->delete();
        return response()->json(['message' => 'Superior deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE superior")
        ]);
    }
}
