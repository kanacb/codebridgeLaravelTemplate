<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\UserPhone;
use App\Interfaces\UserPhoneRepositoryInterface;
use App\Http\Requests\CreateUserPhoneRequest;

class UserPhoneController extends Controller
{
    private UserPhoneRepositoryInterface $UserPhoneRepository;

    public function __construct(UserPhoneRepositoryInterface $userRepository) 
    {
        $this->UserPhoneRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->UserPhoneRepository->getAllUserPhones()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->UserPhoneRepository->getAllUserPhones()
        ]);
    }

    public function store(CreateUserPhoneRequest $request): JsonResponse 
    {
        $data = UserPhone::create($request->validated());
        return response()->json(['message' => 'UserPhone created successfully', 'data' => $data]);
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
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateUserPhoneRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->UserPhoneRepository->updateUserPhone( $id, (array) $newData);
        return response()->json(['message' => 'UserPhone updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = UserPhone::find($id);
        $post->delete();
        return response()->json(['message' => 'UserPhone deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE userPhones")
        ]);
    }

}
