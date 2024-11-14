<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogin;
use App\Interfaces\UserLoginRepositoryInterface;
use App\Http\Requests\CreateUserLoginRequest;
use App\Http\Resources\UserLoginResource;


class UserLoginController extends Controller
{
    private UserLoginRepositoryInterface $UserLoginRepository;

    public function __construct(UserLoginRepositoryInterface $userRepository)
    {
        $this->UserLoginRepository = $userRepository;
        $this->middleware('guest')->except([
            'store'
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $query = UserLogin::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('loginEmail')) {
            $query->where('loginEmail', $request->input('loginEmail'));
        }
        if ($request->has('access')) {
            $query->where('access', $request->input('access'));
        }
        if ($request->has('sendMailCounter')) {
            $query->where('sendMailCounter', $request->input('sendMailCounter'));
        }
        if ($request->has('code')) {
            $query->where('code', $request->input('code'));
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
        return response()->json(["data" => UserLoginResource::collection($results)]);
    }

    public function store(CreateUserLoginRequest $request): JsonResponse
    {
        $request->merge(['created_by' => Auth::id(), 'updated_by' => Auth::id()]);
        $data = UserLogin::create($request->all());
        return response()->json(new UserLoginResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = UserLogin::query();

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

        $data = UserLogin::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id)->$query->get();
        return response()->json(UserLoginResource::collection($data));
    }

    public function update(CreateUserLoginRequest $request, $id): JsonResponse
    {
        $request->merge(['updated_by' => Auth::id()]);
        $newData = $request->except(["id", "created_at"]);
        $data = $this->UserLoginRepository->updateUserLogin($id, (array) $newData);
        return response()->json(new UserLoginResource($data));
    }

    public function destroy($id)
    {
        $post = UserLogin::find($id);
        $post->delete();
        return response()->json(['message' => 'UserLogin deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE user_logins")
        ]);
    }
}
