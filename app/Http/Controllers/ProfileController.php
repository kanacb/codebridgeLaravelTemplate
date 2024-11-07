<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Interfaces\ProfileRepositoryInterface;
use App\Http\Requests\CreateProfileRequest;
use App\Http\Resources\ProfileResource;

class ProfileController extends Controller
{
    private ProfileRepositoryInterface $ProfileRepository;

    public function __construct(ProfileRepositoryInterface $userRepository) 
    {
        $this->ProfileRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse 
    {
        $query = Profile::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('name')) {$query->where('name', $request->input('name'));}
if ($request->has('userId')) {$query->where('userId', $request->input('userId'));}
if ($request->has('image')) {$query->where('image', $request->input('image'));}
if ($request->has('bio')) {$query->where('bio', $request->input('bio'));}
if ($request->has('department')) {$query->where('department', $request->input('department'));}
if ($request->has('hod')) {$query->where('hod', $request->input('hod'));}
if ($request->has('section')) {$query->where('section', $request->input('section'));}
if ($request->has('hos')) {$query->where('hos', $request->input('hos'));}
if ($request->has('position')) {$query->where('position', $request->input('position'));}
if ($request->has('manager')) {$query->where('manager', $request->input('manager'));}
if ($request->has('company')) {$query->where('company', $request->input('company'));}
if ($request->has('branch')) {$query->where('branch', $request->input('branch'));}
if ($request->has('skills')) {$query->where('skills', $request->input('skills'));}
if ($request->has('address')) {$query->where('address', $request->input('address'));}
if ($request->has('phone')) {$query->where('phone', $request->input('phone'));}

        // Handle pagination
        $limit = $request->input('$limit', 10);  // Default to 10 items
        $skip = $request->input('$skip', 0);  // Default to no offset

        $query->limit($limit)->offset($skip);

        // Handle sorting
        if ($request->has('$sort')) {
            foreach ($request->input('$sort') as $field => $order) {
                if($field === "createdAt") $field = "created_at";
                if($field === "updatedAt") $field = "updated_at";
                if($field === "_id") $field = "id";
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
        return response()->json(["data" => ProfileResource::collection($results)]);
    }

    public function store(CreateProfileRequest $request): JsonResponse 
    {
        // if objectid
        // if (is_array($request->input('name'))) {
        //     $request->merge([
        //         'name' => $request->input('name')->_id
        //     ]);
        // }
        //if date
        // if (is_array($request->input('purchasedDate'))) {
        //     $request->merge([
        //         'purchasedDate' => $request->input('purchasedDate')
        //     ]);
        // }
        $data = Profile::create($request->validated());
        return response()->json(new ProfileResource($data));
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
        ])->findOrFail($id)->$query->get();
        return response()->json(ProfileResource::collection($data));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $newData = $request->except(["created_at","updated_at"]);
        $data = $this->ProfileRepository->updateProfile( $id, (array) $newData);
        return response()->json(new ProfileResource($data));
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
