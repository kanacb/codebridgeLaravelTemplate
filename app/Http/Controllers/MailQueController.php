<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\MailQue;
use App\Interfaces\MailQueRepositoryInterface;
use App\Http\Requests\CreateMailQueRequest;
use App\Http\Resources\MailQueResource;
use App\Jobs\SendAfterCommitMailQueJob;

class MailQueController extends Controller
{
    private MailQueRepositoryInterface $MailQueRepository;

    public function __construct(MailQueRepositoryInterface $userRepository)
    {
        $this->MailQueRepository = $userRepository;
        $this->middleware('auth:sanctum')->except(['store']);
    }

    public function index(Request $request): JsonResponse
    {
        $query = MailQue::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('name')) {
            $query->where('name', $request->input('name'));
        }
        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }
        if ($request->has('data')) {
            $query->where('data', $request->input('data'));
        }
        if ($request->has('from')) {
            $query->where('from', $request->input('from'));
        }
        if ($request->has('recipients')) {
            $query->where('recipients', $request->input('recipients'));
        }
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->has('errors')) {
            $query->where('errors', $request->input('errors'));
        }
        if ($request->has('templateId')) {
            $query->where('templateId', $request->input('templateId'));
        }
        if ($request->has('content')) {
            $query->where('content', $request->input('content'));
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
        return response()->json(["data" => MailQueResource::collection($results)]);
    }

    public function store(CreateMailQueRequest $request): JsonResponse
    {
        if (is_array($request->input('recipients'))) {
            $request->merge([
                'recipients' => json_encode($request->input('recipients'))
            ]);
        }
        if (is_array($request->input('data'))) {
            $request->merge([
                'data' => json_encode($request->input('data'))
            ]);
        }
        $data = MailQue::create($request->validated());
        SendAfterCommitMailQueJob::dispatch($data)->afterCommit();
        return response()->json(new MailQueResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = MailQue::query();

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

        $data = MailQue::findOrFail($id)->$query->get();
        return response()->json(MailQueResource::collection($data));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $newData = $request->except(["created_at", "updated_at"]);
        $data = $this->MailQueRepository->updateMailQue($id, (array) $newData);
        return response()->json(new MailQueResource($data));
    }

    public function destroy($id)
    {
        $post = MailQue::find($id);
        $post->delete();
        return response()->json(['message' => 'MailQue deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE mailQues")
        ]);
    }
}
