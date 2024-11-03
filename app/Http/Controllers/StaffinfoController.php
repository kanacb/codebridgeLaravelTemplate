<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Staffinfo;
use App\Interfaces\StaffinfoRepositoryInterface;
use App\Http\Requests\CreateStaffinfoRequest;

class StaffinfoController extends Controller
{
    private StaffinfoRepositoryInterface $StaffinfoRepository;

    public function __construct(StaffinfoRepositoryInterface $userRepository) 
    {
        $this->StaffinfoRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse 
    {
        $query = Staffinfo::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('empno')) {$query->where('empno', $request->input('empno'));}
if ($request->has('name')) {$query->where('name', $request->input('name'));}
if ($request->has('namenric')) {$query->where('namenric', $request->input('namenric'));}
if ($request->has('compcode')) {$query->where('compcode', $request->input('compcode'));}
if ($request->has('compname')) {$query->where('compname', $request->input('compname'));}
if ($request->has('deptcode')) {$query->where('deptcode', $request->input('deptcode'));}
if ($request->has('deptdesc')) {$query->where('deptdesc', $request->input('deptdesc'));}
if ($request->has('sectcode')) {$query->where('sectcode', $request->input('sectcode'));}
if ($request->has('sectdesc')) {$query->where('sectdesc', $request->input('sectdesc'));}
if ($request->has('designation')) {$query->where('designation', $request->input('designation'));}
if ($request->has('email')) {$query->where('email', $request->input('email'));}
if ($request->has('resign')) {$query->where('resign', $request->input('resign'));}
if ($request->has('supervisor')) {$query->where('supervisor', $request->input('supervisor'));}
if ($request->has('datejoin')) {$query->where('datejoin', $request->input('datejoin'));}
if ($request->has('empgroup')) {$query->where('empgroup', $request->input('empgroup'));}
if ($request->has('empgradecode')) {$query->where('empgradecode', $request->input('empgradecode'));}
if ($request->has('terminationdate')) {$query->where('terminationdate', $request->input('terminationdate'));}

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
        return response()->json(["data" => $results]);
    }

    public function store(CreateStaffinfoRequest $request): JsonResponse 
    {
        $data = Staffinfo::create($request->validated());
        return response()->json(['message' => 'Staffinfo created successfully', 'data' => $data]);
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Staffinfo::query();

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

        $data = Staffinfo::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id)->$query->get();
        return response()->json($data);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $newData = $request->except(["created_at","updated_at"]);
        $data = $this->StaffinfoRepository->updateStaffinfo( $id, (array) $newData);
        return response()->json(['message' => 'Staffinfo updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = Staffinfo::find($id);
        $post->delete();
        return response()->json(['message' => 'Staffinfo deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE staffinfo")
        ]);
    }

}
