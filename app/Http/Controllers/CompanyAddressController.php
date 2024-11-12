<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyAddress;
use App\Interfaces\CompanyAddressRepositoryInterface;
use App\Http\Requests\CreateCompanyAddressRequest;
use App\Http\Resources\CompanyAddressResource;


class CompanyAddressController extends Controller
{
    private CompanyAddressRepositoryInterface $CompanyAddressRepository;

    public function __construct(CompanyAddressRepositoryInterface $userRepository)
    {
        $this->CompanyAddressRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $query = CompanyAddress::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('companyId')) {
            $query->where('companyId', $request->input('companyId'));
        }
        if ($request->has('Street1')) {
            $query->where('Street1', $request->input('Street1'));
        }
        if ($request->has('Street2')) {
            $query->where('Street2', $request->input('Street2'));
        }
        if ($request->has('Poscode')) {
            $query->where('Poscode', $request->input('Poscode'));
        }
        if ($request->has('City')) {
            $query->where('City', $request->input('City'));
        }
        if ($request->has('State')) {
            $query->where('State', $request->input('State'));
        }
        if ($request->has('Province')) {
            $query->where('Province', $request->input('Province'));
        }
        if ($request->has('Country')) {
            $query->where('Country', $request->input('Country'));
        }
        if ($request->has('isDefault')) {
            $query->where('isDefault', $request->input('isDefault'));
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
        return response()->json(["data" => CompanyAddressResource::collection($results)]);
    }

    public function store(CreateCompanyAddressRequest $request): JsonResponse
    {
        $request->merge(['created_by' => Auth::id(), 'updated_by' => Auth::id()]);
        $data = CompanyAddress::create($request->all());
        return response()->json(new CompanyAddressResource($data));
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
        ])->findOrFail($id)->$query->get();
        return response()->json(CompanyAddressResource::collection($data));
    }

    public function update(CreateCompanyAddressRequest $request, $id): JsonResponse
    {
        $request->merge(['updated_by' => Auth::id()]);
        $newData = $request->except(["id", "created_at"]);
        $data = $this->CompanyAddressRepository->updateCompanyAddress($id, (array) $newData);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $post = CompanyAddress::find($id);
        $post->delete();
        return response()->json(['message' => 'CompanyAddress deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE company_addresses")
        ]);
    }
}
