<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Template;
use App\Interfaces\TemplateRepositoryInterface;
use App\Http\Requests\CreateTemplateRequest;
use App\Http\Resources\TemplateResource;


class TemplateController extends Controller
{
    private TemplateRepositoryInterface $TemplateRepository;

    public function __construct(TemplateRepositoryInterface $userRepository)
    {
        $this->TemplateRepository = $userRepository;
        $this->middleware('auth:sanctum')->except(['index']);
    }

    public function index(Request $request): JsonResponse
    {
        $query = Template::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('name')) {
            $query->where('name', $request->input('name'));
        }
        if ($request->has('subject')) {
            $query->where('subject', $request->input('subject'));
        }
        if ($request->has('body')) {
            $query->where('body', $request->input('body'));
        }
        if ($request->has('image')) {
            $query->where('image', $request->input('image'));
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
        return response()->json(["data" => TemplateResource::collection($results)]);
    }

    public function store(CreateTemplateRequest $request): JsonResponse
    {
        $request->merge(['created_by' => Auth::id(), 'updated_by' => Auth::id()]);
        $data = Template::create($request->all());
        return response()->json(new TemplateResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Template::query();

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

        $data = Template::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id)->$query->get();
        return response()->json(TemplateResource::collection($data));
    }

    public function update(CreateTemplateRequest $request, $id): JsonResponse
    {
        $request->merge(['updated_by' => Auth::id()]);
        $newData = $request->except(["id", "created_at"]);
        $data = $this->TemplateRepository->updateTemplate($id, (array) $newData);
        return response()->json(new TemplateResource($data));
    }

    public function destroy($id)
    {
        $post = Template::find($id);
        $post->delete();
        return response()->json(['message' => 'Template deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE templates")
        ]);
    }
}
