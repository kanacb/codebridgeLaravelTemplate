<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserGuideStep;
use App\Interfaces\UserGuideStepRepositoryInterface;
use App\Http\Requests\CreateUserGuideStepRequest;
use App\Http\Resources\UserGuideStepResource;


class UserGuideStepController extends Controller
{
    private UserGuideStepRepositoryInterface $UserGuideStepRepository;

    public function __construct(UserGuideStepRepositoryInterface $userRepository)
    {
        $this->UserGuideStepRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $query = UserGuideStep::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('userGuideID')) {
            $query->where('userGuideID', $request->input('userGuideID'));
        }
        if ($request->has('steps')) {
            $query->where('steps', $request->input('steps'));
        }
        if ($request->has('description')) {
            $query->where('description', $request->input('description'));
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
        return response()->json(["data" => UserGuideStepResource::collection($results)]);
    }

    public function store(CreateUserGuideStepRequest $request): JsonResponse
    {
        $request->merge(['created_by' => Auth::id(), 'updated_by' => Auth::id()]);
        $data = UserGuideStep::create($request->all());
        return response()->json(new UserGuideStepResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = UserGuideStep::query();

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

        $data = UserGuideStep::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id)->$query->get();
        return response()->json(UserGuideStepResource::collection($data));
    }

    public function update(CreateUserGuideStepRequest $request, $id): JsonResponse
    {
        $request->merge(['updated_by' => Auth::id()]);
        $newData = $request->except(["id", "created_at"]);
        $data = $this->UserGuideStepRepository->updateUserGuideStep($id, (array) $newData);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $post = UserGuideStep::find($id);
        $post->delete();
        return response()->json(['message' => 'UserGuideStep deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE user_guide_steps")
        ]);
    }
}
