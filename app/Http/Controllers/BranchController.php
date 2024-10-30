<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Branch;
use App\Interfaces\BranchRepositoryInterface;
use App\Http\Requests\CreateBranchRequest;

class BranchController extends Controller
{
    private BranchRepositoryInterface $BranchRepository;

    public function __construct(BranchRepositoryInterface $userRepository) 
    {
        $this->BranchRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->BranchRepository->getAllBranches()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->BranchRepository->getAllBranches()
        ]);
    }

    public function store(CreateBranchRequest $request): JsonResponse 
    {
        $data = Branch::create($request->validated());
        return response()->json(['message' => 'Branch created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Branch::query();

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

        $data = Branch::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateBranchRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->BranchRepository->updateBranch( $id, (array) $newData);
        return response()->json(['message' => 'Branch updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = Branch::find($id);
        $post->delete();
        return response()->json(['message' => 'Branch deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE branches")
        ]);
    }

}
