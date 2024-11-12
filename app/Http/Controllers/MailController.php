<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mail;
use App\Interfaces\MailRepositoryInterface;
use App\Http\Requests\CreateMailRequest;
use App\Http\Resources\MailResource;


class MailController extends Controller
{
    private MailRepositoryInterface $MailRepository;

    public function __construct(MailRepositoryInterface $userRepository)
    {
        $this->MailRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $query = Mail::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->has('subject')) {
            $query->where('subject', $request->input('subject'));
        }
        if ($request->has('body')) {
            $query->where('body', $request->input('body'));
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
        return response()->json(["data" => MailResource::collection($results)]);
    }

    public function store(CreateMailRequest $request): JsonResponse
    {
        $request->merge(['created_by' => Auth::id(), 'updated_by' => Auth::id()]);
        $data = Mail::create($request->all());
        return response()->json(new MailResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Mail::query();

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

        $data = Mail::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id)->$query->get();
        return response()->json(MailResource::collection($data));
    }

    public function update(CreateMailRequest $request, $id): JsonResponse
    {
        $request->merge(['updated_by' => Auth::id()]);
        $newData = $request->except(["id", "created_at"]);
        $data = $this->MailRepository->updateMail($id, (array) $newData);
        return response()->json($data);
    }

    public function destroy($id)
    {
        $post = Mail::find($id);
        $post->delete();
        return response()->json(['message' => 'Mail deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE mails")
        ]);
    }
}
