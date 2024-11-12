<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\UserInvite;
use App\Interfaces\UserInviteRepositoryInterface;
use App\Http\Requests\CreateUserInviteRequest;
use App\Http\Resources\UserInviteResource;

class UserInviteController extends Controller
{
    private UserInviteRepositoryInterface $UserInviteRepository;

    public function __construct(UserInviteRepositoryInterface $userRepository)
    {
        $this->UserInviteRepository = $userRepository;
        $this->middleware('guest')->except([
            'store','index'
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $query = UserInvite::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('emailToInvite')) {
            $query->where('emailToInvite', $request->input('emailToInvite'));
        }
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->has('code')) {
            $query->where('code', $request->input('code'));
        }
        if ($request->has('sendMailCounter')) {
            $query->where('sendMailCounter', $request->input('sendMailCounter'));
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
        return response()->json(["data" => UserInviteResource::collection($results)]);
    }

    public function store(CreateUserInviteRequest $request): JsonResponse
    {
        $data = UserInvite::create($request->validated());
        return response()->json(new UserInviteResource($data));
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

        $data = UserInvite::findOrFail($id)->$query->get();
        return response()->json(UserInviteResource::collection($data));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $newData = $request->except(["created_at", "updated_at"]);
        $data = $this->UserInviteRepository->updateUserInvite($id, (array) $newData);
        return response()->json(new UserInviteResource($data));
    }

    public function destroy($id)
    {
        $post = UserInvite::find($id);
        $post->delete();
        return response()->json(['message' => 'UserInvite deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE userInvites")
        ]);
    }
}
