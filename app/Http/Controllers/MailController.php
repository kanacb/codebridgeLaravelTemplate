<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Mail;
use App\Interfaces\MailRepositoryInterface;
use App\Http\Requests\CreateMailRequest;

class MailController extends Controller
{
    private MailRepositoryInterface $MailRepository;

    public function __construct(MailRepositoryInterface $userRepository) 
    {
        $this->MailRepository = $userRepository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'total' => $this->MailRepository->getAllMails()->count(),
            'limit' => 0,
            'skip' => 0,
            'data' => $this->MailRepository->getAllMails()
        ]);
    }

    public function store(CreateMailRequest $request): JsonResponse 
    {
        $data = Mail::create($request->validated());
        return response()->json(['message' => 'Mail created successfully', 'data' => $data]);
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
        ])->findOrFail($id);
        return response()->json($data);
    }

    public function update(CreateMailRequest $request, $id): JsonResponse
    {
        $newData = $request->input();
        $data = $this->MailRepository->updateMail( $id, (array) $newData);
        return response()->json(['message' => 'Mail updated successfully', 'data' => $data, "id" => $id, 'newData' => $newData]);
    }

    public function destroy($id)
    {
        $post = Mail::find($id);
        $post->delete();
        return response()->json(['message' => 'Mail deleted successfully']);
    }

    public function getSchema() : JsonResponse{
        return response()->json([
            \Illuminate\Support\Facades\DB::select("DESCRIBE mails")
        ]);
    }

}
