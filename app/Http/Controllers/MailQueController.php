<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\MailQue;
use App\Interfaces\MailQueRepositoryInterface;
use App\Http\Requests\CreateMailQueRequest;

class MailQueController extends Controller
{
    private MailQueRepositoryInterface $MailQueRepository;

    public function __construct(MailQueRepositoryInterface $userRepository) 
    {
        $this->MailQueRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->MailQueRepository->getAllMailQues()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->MailQueRepository->getAllMailQues()
        ]);
    }

    public function store(CreateMailQueRequest $request): JsonResponse 
    {
        $data = MailQue::create($request->validated());
        return response()->json(['message' => 'MailQue created successfully', 'data' => $data]);
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

        $data = MailQue::with([
            'createdBy' => function ($query) {
                $query->select('id', 'name'); // Assumes 'id' is needed for relationship linking
            },
            'updatedBy' => function ($query) {
                $query->select('id', 'name');
            }
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateMailQueRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->MailQueRepository->updateMailQue( $id, (array) $newData);
        return response()->json(['message' => 'MailQue updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = MailQue::find($id);
        $post->delete();
        return response()->json(['message' => 'MailQue deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE mailQues")
        ]);
    }

}
