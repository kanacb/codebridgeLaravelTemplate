<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use App\Http\Requests\CreateUserRequest;

class UserController extends Controller
{
    private UserRepositoryInterface $UserRepository;

    public function __construct(UserRepositoryInterface $userRepository) 
    {
        $this->UserRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'data' => $this->UserRepository->getAllUsers()
        ]);
    }

    public function store(CreateUserRequest $request): JsonResponse 
    {
        $data = User::create($request->validated());
        return response()->json(['message' => 'User created successfully', 'data' => $data]);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
             \Illuminate\Support\Facades\DB::select("DESCRIBE users")
        ]);
    }

}
