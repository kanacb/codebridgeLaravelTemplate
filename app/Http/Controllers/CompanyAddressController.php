<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\CompanyAddress;
use App\Interfaces\CompanyAddressRepositoryInterface;
use App\Http\Requests\CreateCompanyAddressRequest;

class CompanyAddressController extends Controller
{
    private CompanyAddressRepositoryInterface $CompanyAddressRepository;

    public function __construct(CompanyAddressRepositoryInterface $userRepository) 
    {
        $this->CompanyAddressRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->CompanyAddressRepository->getAllCompanyAddresses()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->CompanyAddressRepository->getAllCompanyAddresses()
        ]);
    }

    public function store(CreateCompanyAddressRequest $request): JsonResponse 
    {
        $data = CompanyAddress::create($request->validated());
        return response()->json(['message' => 'CompanyAddress created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = CompanyAddress::query();

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

        $data = CompanyAddress::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateCompanyAddressRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->CompanyAddressRepository->updateCompanyAddress( $id, (array) $newData);
        return response()->json(['message' => 'CompanyAddress updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = CompanyAddress::find($id);
        $post->delete();
        return response()->json(['message' => 'CompanyAddress deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE companyAddresses")
        ]);
    }

}
