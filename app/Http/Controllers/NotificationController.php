<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Interfaces\NotificationRepositoryInterface;
use App\Http\Requests\CreateNotificationRequest;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    private NotificationRepositoryInterface $NotificationRepository;

    public function __construct(NotificationRepositoryInterface $userRepository)
    {
        $this->NotificationRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $query = Notification::query();

        // Handle specific FeathersJS query parameters
        if ($request->has('toUser')) {
            $query->where('toUser', $request->input('toUser'));
        }
        if ($request->has('content')) {
            $query->where('content', $request->input('content'));
        }
        if ($request->has('read')) {
            $query->where('read', $request->input('read'));
        }
        if ($request->has('sent')) {
            $query->where('sent', $request->input('sent'));
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
        return response()->json(["data" => $results]);
    }

    public function store(CreateNotificationRequest $request): JsonResponse
    {
        $data = Notification::create($request->validated());
        return response()->json(new NotificationResource($data));
    }

    public function show(Request $request,  $id): JsonResponse
    {

        $query = Notification::query();

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

        $data = Notification::with([
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
        $newData = $request->except(["created_at", "updated_at"]);
        $data = $this->NotificationRepository->updateNotification($id, (array) $newData);
        return response()->json(['message' => 'Notification updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = Notification::find($id);
        $post->delete();
        return response()->json(['message' => 'Notification deleted successfully']);
    }

    public function getSchema(): JsonResponse
    {
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE notifications")
        ]);
    }
}
