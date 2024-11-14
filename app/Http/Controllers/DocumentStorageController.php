<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DocumentStorage;
use App\Interfaces\DocumentStorageRepositoryInterface;
use App\Http\Requests\CreateDocumentStorageRequest;
use App\Http\Resources\DocumentStorageResource;


class DocumentStorageController extends Controller
{
    private DocumentStorageRepositoryInterface $DocumentStorageRepository;

    public function __construct(DocumentStorageRepositoryInterface $userRepository)
    {
        $this->DocumentStorageRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $query = DocumentStorage::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('name')) {
            $query->where('name', $request->input('name'));
        }
        if ($request->has('size')) {
            $query->where('size', $request->input('size'));
        }
        if ($request->has('path')) {
            $query->where('path', $request->input('path'));
        }
        if ($request->has('lastModifiedDate')) {
            $query->where('lastModifiedDate', $request->input('lastModifiedDate'));
        }
        if ($request->has('lastModified')) {
            $query->where('lastModified', $request->input('lastModified'));
        }
        if ($request->has('eTag')) {
            $query->where('eTag', $request->input('eTag'));
        }
        if ($request->has('url')) {
            $query->where('url', $request->input('url'));
        }
        if ($request->has('tableId')) {
            $query->where('tableId', $request->input('tableId'));
        }
        if ($request->has('tableName')) {
            $query->where('tableName', $request->input('tableName'));
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
        return response()->json(["data" => DocumentStorageResource::collection($results)]);
    }

    public function store(CreateDocumentStorageRequest $request): JsonResponse
    {
        $request->merge(['created_by' => Auth::id(), 'updated_by' => Auth::id()]);
        $data = DocumentStorage::create($request->all());
        return response()->json(new DocumentStorageResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = DocumentStorage::query();

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

        $data = DocumentStorage::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id)->$query->get();
        return response()->json(DocumentStorageResource::collection($data));
    }

    public function update(CreateDocumentStorageRequest $request, $id): JsonResponse
    {
        $request->merge(['updated_by' => Auth::id()]);
        $newData = $request->except(["id", "created_at"]);
        $data = $this->DocumentStorageRepository->updateDocumentStorage($id, (array) $newData);
        return response()->json(new DocumentStorageResource($data));
    }

    public function destroy($id)
    {
        $post = DocumentStorage::find($id);
        $post->delete();
        return response()->json(['message' => 'DocumentStorage deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE document_storages")
        ]);
    }
}
