<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Superior;
use App\Interfaces\SuperiorRepositoryInterface;
use App\Http\Requests\CreateSuperiorRequest;

class SuperiorController extends Controller
{
    private SuperiorRepositoryInterface $SuperiorRepository;

    public function __construct(SuperiorRepositoryInterface $userRepository) 
    {
        $this->SuperiorRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->SuperiorRepository->getAllSuperiors()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->SuperiorRepository->getAllSuperiors()
        ]);
    }

    public function store(CreateSuperiorRequest $request): JsonResponse 
    {
        $data = Superior::create($request->validated());
        return response()->json(['message' => 'Superior created successfully', 'data' => $data]);
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
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateSuperiorRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->SuperiorRepository->updateSuperior( $id, (array) $newData);
        return response()->json(['message' => 'Superior updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = Superior::find($id);
        $post->delete();
        return response()->json(['message' => 'Superior deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE superior")
        ]);
    }

}
