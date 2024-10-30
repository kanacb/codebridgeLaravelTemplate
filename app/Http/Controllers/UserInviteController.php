<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\UserInvite;
use App\Interfaces\UserInviteRepositoryInterface;
use App\Http\Requests\CreateUserInviteRequest;

class UserInviteController extends Controller
{
    private UserInviteRepositoryInterface $UserInviteRepository;

    public function __construct(UserInviteRepositoryInterface $userRepository) 
    {
        $this->UserInviteRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->UserInviteRepository->getAllUserInvites()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->UserInviteRepository->getAllUserInvites()
        ]);
    }

    public function store(CreateUserInviteRequest $request): JsonResponse 
    {
        $data = UserInvite::create($request->validated());
        return response()->json(['message' => 'UserInvite created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = UserInvite::query();

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

        $data = UserInvite::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateUserInviteRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->UserInviteRepository->updateUserInvite( $id, (array) $newData);
        return response()->json(['message' => 'UserInvite updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = UserInvite::find($id);
        $post->delete();
        return response()->json(['message' => 'UserInvite deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE userInvites")
        ]);
    }

}
