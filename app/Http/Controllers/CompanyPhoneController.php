<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CompanyPhone;
use App\Interfaces\CompanyPhoneRepositoryInterface;
use App\Http\Requests\CreateCompanyPhoneRequest;

class CompanyPhoneController extends Controller
{
    private CompanyPhoneRepositoryInterface $CompanyPhoneRepository;

    public function __construct(CompanyPhoneRepositoryInterface $userRepository) 
    {
        $this->CompanyPhoneRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->CompanyPhoneRepository->getAllCompanyPhones()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->CompanyPhoneRepository->getAllCompanyPhones()
        ]);
    }

    public function store(CreateCompanyPhoneRequest $request): JsonResponse 
    {
        $data = CompanyPhone::create($request->validated());
        return response()->json(['message' => 'CompanyPhone created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = CompanyPhone::query();

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

        $data = CompanyPhone::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateCompanyPhoneRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->CompanyPhoneRepository->updateCompanyPhone( $id, (array) $newData);
        return response()->json(['message' => 'CompanyPhone updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = CompanyPhone::find($id);
        $post->delete();
        return response()->json(['message' => 'CompanyPhone deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE companyPhones")
        ]);
    }

}
