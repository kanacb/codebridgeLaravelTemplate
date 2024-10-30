<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\JobQue;
use App\Interfaces\JobQueRepositoryInterface;
use App\Http\Requests\CreateJobQueRequest;

class JobQueController extends Controller
{
    private JobQueRepositoryInterface $JobQueRepository;

    public function __construct(JobQueRepositoryInterface $userRepository) 
    {
        $this->JobQueRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->JobQueRepository->getAllJobQues()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->JobQueRepository->getAllJobQues()
        ]);
    }

    public function store(CreateJobQueRequest $request): JsonResponse 
    {
        $data = JobQue::create($request->validated());
        return response()->json(['message' => 'JobQue created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = JobQue::query();

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

        $data = JobQue::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateJobQueRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->JobQueRepository->updateJobQue( $id, (array) $newData);
        return response()->json(['message' => 'JobQue updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = JobQue::find($id);
        $post->delete();
        return response()->json(['message' => 'JobQue deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE jobQues")
        ]);
    }

}
