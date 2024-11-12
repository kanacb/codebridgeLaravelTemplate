<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Interfaces\CompanyRepositoryInterface;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Resources\CompanyResource;


class CompanyController extends Controller
{
    private CompanyRepositoryInterface $CompanyRepository;

    public function __construct(CompanyRepositoryInterface $userRepository)
    {
        $this->CompanyRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $query = Company::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('name')) {
            $query->where('name', $request->input('name'));
        }
        if ($request->has('companyNo')) {
            $query->where('companyNo', $request->input('companyNo'));
        }
        if ($request->has('newCompanyNumber')) {
            $query->where('newCompanyNumber', $request->input('newCompanyNumber'));
        }
        if ($request->has('DateIncorporated')) {
            $query->where('DateIncorporated', $request->input('DateIncorporated'));
        }
        if ($request->has('isdefault')) {
            $query->where('isdefault', $request->input('isdefault'));
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
        return response()->json(["data" => CompanyResource::collection($results)]);
    }

    public function store(CreateCompanyRequest $request): JsonResponse
    {
        $request->merge(['created_by' => Auth::id(), 'updated_by' => Auth::id()]);
        $data = Company::create($request->all());
        return response()->json(new CompanyResource($data));
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
        ])->findOrFail($id)->$query->get();
        return response()->json(CompanyResource::collection($data));
    }

    public function update(CreateCompanyRequest $request, $id): JsonResponse
    {
        $request->merge(['updated_by' => Auth::id()]);
        $newData = $request->except(["id", "created_at"]);
        $data = $this->CompanyRepository->updateCompany($id, (array) $newData);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $post = Company::find($id);
        $post->delete();
        return response()->json(['message' => 'Company deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE companies")
        ]);
    }
}
