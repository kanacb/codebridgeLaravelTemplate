<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->TemplateRepository->getAllTemplates()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->TemplateRepository->getAllTemplates()
        ]);
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
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateTemplateRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->TemplateRepository->updateTemplate( $id, (array) $newData);
        return response()->json(['message' => 'Template updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = Template::find($id);
        $post->delete();
        return response()->json(['message' => 'Template deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE templates")
        ]);
    }

}
