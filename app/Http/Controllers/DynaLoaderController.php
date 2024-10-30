<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\DynaLoader;
use App\Interfaces\DynaLoaderRepositoryInterface;
use App\Http\Requests\CreateDynaLoaderRequest;

class DynaLoaderController extends Controller
{
    private DynaLoaderRepositoryInterface $DynaLoaderRepository;

    public function __construct(DynaLoaderRepositoryInterface $userRepository) 
    {
        $this->DynaLoaderRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->DynaLoaderRepository->getAllDynaLoaders()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->DynaLoaderRepository->getAllDynaLoaders()
        ]);
    }

    public function store(CreateDynaLoaderRequest $request): JsonResponse 
    {
        $data = DynaLoader::create($request->validated());
        return response()->json(['message' => 'DynaLoader created successfully', 'data' => $data]);
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
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateDynaLoaderRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->DynaLoaderRepository->updateDynaLoader( $id, (array) $newData);
        return response()->json(['message' => 'DynaLoader updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
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
