<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\DynaField;
use App\Interfaces\DynaFieldRepositoryInterface;
use App\Http\Requests\CreateDynaFieldRequest;

class DynaFieldController extends Controller
{
    private DynaFieldRepositoryInterface $DynaFieldRepository;

    public function __construct(DynaFieldRepositoryInterface $userRepository) 
    {
        $this->DynaFieldRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->DynaFieldRepository->getAllDynaFields()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->DynaFieldRepository->getAllDynaFields()
        ]);
    }

    public function store(CreateDynaFieldRequest $request): JsonResponse 
    {
        $data = DynaField::create($request->validated());
        return response()->json(['message' => 'DynaField created successfully', 'data' => $data]);
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
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateDynaFieldRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->DynaFieldRepository->updateDynaField( $id, (array) $newData);
        return response()->json(['message' => 'DynaField updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
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
