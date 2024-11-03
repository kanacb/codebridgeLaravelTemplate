<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    public function index(Request $request): JsonResponse
    {
        $query = Branch::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('companyId')) {
            $query->where('companyId', $request->input('companyId'));
        }
        if ($request->has('name')) {
            $query->where('name', $request->input('name'));
        }
        if ($request->has('isDefault')) {
            $query->where('isDefault', $request->input('isDefault'));
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
        ])->findOrFail($id)->$query->get();
        return response()->json($data);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $newData = $request->except(["created_at", "updated_at"]);
        $data = $this->BranchRepository->updateBranch($id, (array) $newData);
        return response()->json(['message' => 'Branch updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = Branch::find($id);
        $post->delete();
        return response()->json(['message' => 'Branch deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE branches")
        ]);
    }
}
