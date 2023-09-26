module.exports = `<?php

namespace App\Http\Controllers;

use App\Interfaces\~cb-service-name~RepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
~cb-app-service-controller-use~

class ~cb-service-name~Controller extends Controller 
{
    private ~cb-service-name~RepositoryInterface $~cb-service-name~Repository;

    public function __construct(~cb-service-name~RepositoryInterface $~cb-service-name~Repository) 
    {
        $this->~cb-service-name~Repository = $~cb-service-name~Repository;
    }

    public function index(): JsonResponse 
    {
        return response()->json([
            'data' => $this->~cb-service-name~Repository->getAll~cb-service-name~s()
        ]);
    }

    public function store(Request $request): JsonResponse 
    {
        $~cb-service-name~Details = $request->only([
            ~cb-service-fieldname~
        ]);

        return response()->json(
            [
                'data' => $this->~cb-service-name~Repository->create~cb-service-name~($~cb-service-name~Details)
            ],
            Response::HTTP_CREATED
        );
    }

    public function show(Request $request): JsonResponse 
    {
        $~cb-service-name~Id = $request->route('id');

        return response()->json([
            'data' => $this->~cb-service-name~Repository->get~cb-service-name~ById($~cb-service-name~Id)
        ]);
    }

    public function update(Request $request): JsonResponse 
    {
        $~cb-service-name~Id = $request->route('id');
        $~cb-service-name~Details = $request->only([
            'client',
            'details'
        ]);

        return response()->json([
            'data' => $this->~cb-service-name~Repository->update~cb-service-name~($~cb-service-name~Id, $~cb-service-name~Details)
        ]);
    }

    public function destroy(Request $request): JsonResponse 
    {
        $~cb-service-name~Id = $request->route('id');
        $this->~cb-service-name~Repository->delete~cb-service-name~($~cb-service-name~Id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}`;
