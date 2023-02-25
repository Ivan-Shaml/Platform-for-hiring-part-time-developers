<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeveloperRequest;
use App\Http\Resources\DeveloperResource;
use App\Services\Contracts\IDeveloperService;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class DevelopersApiController extends Controller
{
    private IDeveloperService $developerService;

    /**
     * @param IDeveloperService $developerService
     */
    public function __construct(IDeveloperService $developerService)
    {
        $this->developerService = $developerService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return DeveloperResource::collection($this->developerService->getDevelopers());
    }

    public function show(int $id)
    {
        $developer = $this->developerService->getDeveloperById($id);

        if (is_null($developer)) {
            return new Response('', ResponseAlias::HTTP_NOT_FOUND);
        }

        return new Response(json_encode($developer), ResponseAlias::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(DeveloperRequest $request)
    {
        $this->developerService->createDeveloper($request);

        return response()->json([
            'status' => 'success',
            'message' => 'Developer created successfully',
            'developer' => $request->validated(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DeveloperRequest $request)
    {
        $this->developerService->createDeveloper($request);

        return response()->json([
            'status' => 'success',
            'message' => 'Developer created successfully',
            'developer' => $request->validated(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Developer $developer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DeveloperRequest $request, $id)
    {
        $this->developerService->updateDeveloper($request, $id);

        return response()->json([
            'status' => 'success',
            'message' => 'Developer updated successfully',
            'developer' => $request->validated(),
        ]);
    }

    public function destroy(int $id)
    {
        $result = $this->developerService->deleteDeveloper($id);
        return ($result ? new Response('', ResponseAlias::HTTP_NO_CONTENT) : new Response('', ResponseAlias::HTTP_NOT_FOUND));
    }
}
