<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Inbox;
use App\Interfaces\InboxRepositoryInterface;
use App\Http\Requests\CreateInboxRequest;
use App\Http\Resources\InboxResource;

class InboxController extends Controller
{
    private InboxRepositoryInterface $InboxRepository;

    public function __construct(InboxRepositoryInterface $userRepository) 
    {
        $this->InboxRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse 
    {
        $query = Inbox::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('from')) {$query->where('from', $request->input('from'));}
if ($request->has('toUser')) {$query->where('toUser', $request->input('toUser'));}
if ($request->has('content')) {$query->where('content', $request->input('content'));}
if ($request->has('read')) {$query->where('read', $request->input('read'));}
if ($request->has('sent')) {$query->where('sent', $request->input('sent'));}

        // Handle pagination
        $limit = $request->input('$limit', 10);  // Default to 10 items
        $skip = $request->input('$skip', 0);  // Default to no offset

        $query->limit($limit)->offset($skip);

        // Handle sorting
        if ($request->has('$sort')) {
            foreach ($request->input('$sort') as $field => $order) {
                if($field === "createdAt") $field = "created_at";
                if($field === "updatedAt") $field = "updated_at";
                if($field === "_id") $field = "id";
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
        return response()->json(["data" => InboxResource::collection($results)]);
    }

    public function store(CreateInboxRequest $request): JsonResponse 
    {
        // if objectid
        // if (is_array($request->input('name'))) {
        //     $request->merge([
        //         'name' => $request->input('name')->_id
        //     ]);
        // }
        //if date
        // if (is_array($request->input('purchasedDate'))) {
        //     $request->merge([
        //         'purchasedDate' => $request->input('purchasedDate')
        //     ]);
        // }
        $data = Inbox::create($request->validated());
        return response()->json(new InboxResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Inbox::query();

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

        $data = Inbox::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id)->$query->get();
        return response()->json(InboxResource::collection($data));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $newData = $request->except(["created_at","updated_at"]);
        $data = $this->InboxRepository->updateInbox( $id, (array) $newData);
        return response()->json(new InboxResource($data));
    }

    public function destroy($id)
    {
        $post = Inbox::find($id);
        $post->delete();
        return response()->json(['message' => 'Inbox deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE inbox")
        ]);
    }

}
