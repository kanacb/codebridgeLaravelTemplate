<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\UserAddress;
use App\Interfaces\UserAddressRepositoryInterface;
use App\Http\Requests\CreateUserAddressRequest;

class UserAddressController extends Controller
{
    private UserAddressRepositoryInterface $UserAddressRepository;

    public function __construct(UserAddressRepositoryInterface $userRepository) 
    {
        $this->UserAddressRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->UserAddressRepository->getAllUserAddresses()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->UserAddressRepository->getAllUserAddresses()
        ]);
    }

    public function store(CreateUserAddressRequest $request): JsonResponse 
    {
        $data = UserAddress::create($request->validated());
        return response()->json(['message' => 'UserAddress created successfully', 'data' => $data]);
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
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateUserAddressRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->UserAddressRepository->updateUserAddress( $id, (array) $newData);
        return response()->json(['message' => 'UserAddress updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = UserAddress::find($id);
        $post->delete();
        return response()->json(['message' => 'UserAddress deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE userAddresses")
        ]);
    }

}
