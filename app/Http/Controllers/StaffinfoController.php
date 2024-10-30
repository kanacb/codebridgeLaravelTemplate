<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Staffinfo;
use App\Interfaces\StaffinfoRepositoryInterface;
use App\Http\Requests\CreateStaffinfoRequest;

class StaffinfoController extends Controller
{
    private StaffinfoRepositoryInterface $StaffinfoRepository;

    public function __construct(StaffinfoRepositoryInterface $userRepository) 
    {
        $this->StaffinfoRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->StaffinfoRepository->getAllStaffinfos()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->StaffinfoRepository->getAllStaffinfos()
        ]);
    }

    public function store(CreateStaffinfoRequest $request): JsonResponse 
    {
        $data = Staffinfo::create($request->validated());
        return response()->json(['message' => 'Staffinfo created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Staffinfo::query();

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

        $data = Staffinfo::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateStaffinfoRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->StaffinfoRepository->updateStaffinfo( $id, (array) $newData);
        return response()->json(['message' => 'Staffinfo updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = Staffinfo::find($id);
        $post->delete();
        return response()->json(['message' => 'Staffinfo deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE staffinfo")
        ]);
    }

}
