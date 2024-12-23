<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPhone;
use App\Interfaces\UserPhoneRepositoryInterface;
use App\Http\Requests\CreateUserPhoneRequest;
use App\Http\Resources\UserPhoneResource;


class UserPhoneController extends Controller
{
    private UserPhoneRepositoryInterface $UserPhoneRepository;

    public function __construct(UserPhoneRepositoryInterface $userRepository)
    {
        $this->UserPhoneRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $query = UserPhone::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('userId')) {
            $query->where('userId', $request->input('userId'));
        }
        if ($request->has('countryCode')) {
            $query->where('countryCode', $request->input('countryCode'));
        }
        if ($request->has('operatorCode')) {
            $query->where('operatorCode', $request->input('operatorCode'));
        }
        if ($request->has('number')) {
            $query->where('number', $request->input('number'));
        }
        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
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
        return response()->json(["data" => UserPhoneResource::collection($results)]);
    }

    public function store(CreateUserPhoneRequest $request): JsonResponse
    {
        $request->merge(['created_by' => Auth::id(), 'updated_by' => Auth::id()]);
        $data = UserPhone::create($request->all());
        return response()->json(new UserPhoneResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = UserPhone::query();

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

        $data = UserPhone::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id)->$query->get();
        return response()->json(UserPhoneResource::collection($data));
    }

    public function update(CreateUserPhoneRequest $request, $id): JsonResponse
    {
        $request->merge(['updated_by' => Auth::id()]);
        $newData = $request->except(["id", "created_at"]);
        $data = $this->UserPhoneRepository->updateUserPhone($id, (array) $newData);
        return response()->json(new UserPhoneResource($data));
    }

    public function destroy($id)
    {
        $post = UserPhone::find($id);
        $post->delete();
        return response()->json(['message' => 'UserPhone deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE user_phones")
        ]);
    }
}
