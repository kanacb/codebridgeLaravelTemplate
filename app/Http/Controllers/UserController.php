<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller 
{
    private UserRepositoryInterface $UserRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->UserRepository = $userRepository;
        $this->middleware('guest')->except([
            'store'
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $query = User::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('name')) {
            $query->where('name', $request->input('name'));
        }
        if ($request->has('email')) {
            $query->where('email', $request->input('email'));
        }
        if ($request->has('email_verified_at')) {
            $query->where('email_verified_at', $request->input('email_verified_at'));
        }
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->has('remember_token')) {
            $query->where('remember_token', $request->input('remember_token'));
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
        return response()->json(["data" => UserResource::collection($results)]);
    }

    public function show(Request $request, $id): JsonResponse
    {
        $data = User::findOrFail($id)->get();
        return response()->json(new UserResource($data));
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        $data = User::create($request->validated());
        return response()->json(new UserResource($data));
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE users")
        ]);
    }
}
