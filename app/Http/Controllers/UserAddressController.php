<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Interfaces\UserAddressRepositoryInterface;
use App\Http\Requests\CreateUserAddressRequest;
use App\Http\Resources\UserAddressResource;

class UserAddressController extends Controller
{
    private UserAddressRepositoryInterface $UserAddressRepository;

    public function __construct(UserAddressRepositoryInterface $userRepository)
    {
        $this->UserAddressRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $query = UserAddress::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('userId')) {
            $query->where('userId', $request->input('userId'));
        }
        if ($request->has('Street1')) {
            $query->where('Street1', $request->input('Street1'));
        }
        if ($request->has('Street2')) {
            $query->where('Street2', $request->input('Street2'));
        }
        if ($request->has('Poscode')) {
            $query->where('Poscode', $request->input('Poscode'));
        }
        if ($request->has('City')) {
            $query->where('City', $request->input('City'));
        }
        if ($request->has('State')) {
            $query->where('State', $request->input('State'));
        }
        if ($request->has('Province')) {
            $query->where('Province', $request->input('Province'));
        }
        if ($request->has('Country')) {
            $query->where('Country', $request->input('Country'));
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
        return response()->json(["data" => $results]);
    }

    public function store(CreateUserAddressRequest $request): JsonResponse
    {
        $data = UserAddress::create($request->validated());
        return response()->json(new UserAddressResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = UserAddress::query();

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

        $data = UserAddress::with([
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
        $data = $this->UserAddressRepository->updateUserAddress($id, (array) $newData);
        return response()->json(['message' => 'UserAddress updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = UserAddress::find($id);
        $post->delete();
        return response()->json(['message' => 'UserAddress deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE userAddresses")
        ]);
    }
}
