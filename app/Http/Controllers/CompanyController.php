<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Company;
use App\Interfaces\CompanyRepositoryInterface;
use App\Http\Requests\CreateCompanyRequest;

class CompanyController extends Controller
{
    private CompanyRepositoryInterface $CompanyRepository;

    public function __construct(CompanyRepositoryInterface $userRepository) 
    {
        $this->CompanyRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->CompanyRepository->getAllCompanies()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->CompanyRepository->getAllCompanies()
        ]);
    }

    public function store(CreateCompanyRequest $request): JsonResponse 
    {
        $data = Company::create($request->validated());
        return response()->json(['message' => 'Company created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Company::query();

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

        $data = Company::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateCompanyRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->CompanyRepository->updateCompany( $id, (array) $newData);
        return response()->json(['message' => 'Company updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = Company::find($id);
        $post->delete();
        return response()->json(['message' => 'Company deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE companies")
        ]);
    }

}
