<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Profile;
use App\Interfaces\ProfileRepositoryInterface;
use App\Http\Requests\CreateProfileRequest;

class ProfileController extends Controller
{
    private ProfileRepositoryInterface $ProfileRepository;

    public function __construct(ProfileRepositoryInterface $userRepository) 
    {
        $this->ProfileRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->ProfileRepository->getAllProfiles()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->ProfileRepository->getAllProfiles()
        ]);
    }

    public function store(CreateProfileRequest $request): JsonResponse 
    {
        $data = Profile::create($request->validated());
        return response()->json(['message' => 'Profile created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Profile::query();

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

        $data = Profile::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateProfileRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->ProfileRepository->updateProfile( $id, (array) $newData);
        return response()->json(['message' => 'Profile updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = Profile::find($id);
        $post->delete();
        return response()->json(['message' => 'Profile deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE profiles")
        ]);
    }

}
