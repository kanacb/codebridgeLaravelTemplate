<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Interfaces\TemplateRepositoryInterface;
use App\Http\Requests\CreateTemplateRequest;

class TemplateController extends Controller
{
    private TemplateRepositoryInterface $TemplateRepository;

    public function __construct(TemplateRepositoryInterface $userRepository)
    {
        $this->TemplateRepository = $userRepository;
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
        return response()->json($results);
    }

    public function store(CreateTemplateRequest $request): JsonResponse
    {
        $data = Template::create($request->validated());
        return response()->json(['message' => 'Template created successfully', 'data' => $data]);
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
        return response()->json($data);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $newData = $request->except(["created_at", "updated_at"]);
        $data = $this->TemplateRepository->updateTemplate($id, (array) $newData);
        return response()->json(['message' => 'Template updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
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
